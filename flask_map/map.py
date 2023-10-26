from flask import Blueprint
from flask import render_template
#import subprocess

# 1パラ目はendpointのモジュールnamespace?
map_module = Blueprint("map", __name__)


import json
import psycopg2
from utils import dump


def line_geojson(epsg):
    dsn = "dbname=map host=localhost user=postgres"
    lines = []
    sql = """
select
    ST_AsGeoJSON(ST_Transform(wkb_geometry, {srs})) as geom,
    ogc_fid, keycode, 名称
from m2023.main_line h
""".format(srs=epsg)
    print(sql)
    with psycopg2.connect(dsn) as conn:
        with conn.cursor() as cur:
            cur.execute(sql)
            for row in cur:
                geo = json.loads(row[0])
                feature = {
                    'type': 'Feature',
                    'geometry': geo,
                    'properties': {
                        'ogc_fid': row[1],
                        'keycode': row[2],
                        'name': row[3]
                    }
                }
                #print(feature)
                lines.append(feature)
    return lines

def all_line_geojson(schema_name, table_name, epsg):
    dsn = "dbname=map host=localhost user=postgres"
    lines = []
    sql = """
select
    ST_AsGeoJSON(ST_Transform(wkb_geometry, {srs})) as geom,
    ogc_fid, keycode, 名称
from {schema}.{table} h
""".format(srs=epsg, schema=schema_name, table=table_name)
    print(sql)
    with psycopg2.connect(dsn) as conn:
        with conn.cursor() as cur:
            cur.execute(sql)
            for row in cur:
                geo = json.loads(row[0])
                feature = {
                    'type': 'Feature',
                    'geometry': geo,
                    'properties': {
                        'ogc_fid': row[1],
                        'keycode': row[2],
                        'name': row[3],
                        'layer': table_name
                    }
                }
                #print(feature)
                lines.append(feature)
    return lines

# layer名指定でgeojson取得
def layer_geojson(layer_name):
    epsg = 3857
    dsn = "dbname=map host=localhost user=postgres"
    features = []
    sql = """
select
    ST_AsGeoJSON(ST_Transform(wkb_geometry, {srs})) as geom, *
    from m2023.{name} h
""".format(srs=epsg, name=layer_name)
    print(sql)
    with psycopg2.connect(dsn) as conn:
        # 辞書型で取得
        with conn.cursor(cursor_factory=DictCursor) as cur:
            cur.execute(sql)
            for row in cur:

                print('geo============')
                geo = json.loads(row['geom'])
                print(geo)

                props = {}
                for key in row.keys():
                    if (key != 'geom'):
                        props[key] = row[key]

                feature = {
                    'type': 'Feature',
                    'geometry': geo,
                    'properties': props,
                }
                print('feature============')
                dump(feature)
                features.append(feature)
    return features


from psycopg2.extras import DictCursor
from pprint import pprint

#def geometry_columns():
#    dsn = "dbname=map host=localhost user=postgres"
#    sql = "select * from public.geometry_columns where f_table_schema='m2023'"
#    rows = []
#    with psycopg2.connect(dsn) as conn:
#        with conn.cursor(cursor_factory=DictCursor) as cur:
#            cur.execute(sql)
#            for row in cur:
#                dump(row)
#                rows.append(row)
#    #print('rows len=' + str(len(rows)))
#    return rows


def geometry_columns(schema):
    dsn = "dbname=map host=localhost user=postgres"
    #sql = "select * from information_schema.tables where table_schema='m2023' order by table_schema"
    sql = f"select * from public.geometry_columns where f_table_schema='{schema}'"
    #print(sql)
    rows = []
    with psycopg2.connect(dsn) as conn:
        with conn.cursor(cursor_factory=DictCursor) as cur:
            cur.execute(sql)
            for row in cur:
                dump(row)
                rows.append(row)
    return rows

@map_module.route('/maptables')
def maptables():
    return render_template('tables.html', tables=geometry_columns('m2023'), title='m2023 geometry columns')

# スキーマ内にあるテーブル一覧api
@map_module.route('/maptables_api')
def map_tables_api():
    # オブジェクトを返すだけでjsonになる
    rows = geometry_columns('m2023')
    # rows to dict
    layers = []
    for row in rows:
        layer = {}
        for key in row.keys():
            layer[key] = row[key]
        layers.append(layer)
    return layers

@map_module.route('/map')
def map():
    hojos = line_geojson(3857)
    return render_template('map.html', geojsons=hojos) #, json=hojos_json_string)


@map_module.route('/lines')
def openlayers():
    hojos = line_geojson(3857)
    return render_template('lines.html', geojsons=hojos) #, json=hojos_json_string)


@map_module.route('/lines_api/<string:name>')
def lines_api(name):
    features = layer_geojson(name) # 4326
    #print(features)
    feature_collection = {
        'type': 'FeatureCollection',
        'features': features,
        'crs': {
            'type': 'name',
            'properties': {
                'name': 'EPSG:3857',
            },
        },
    }
    return feature_collection


# lines用全レイヤ一括取得api
@map_module.route('/united_lines_api/<int:code>')
def united_lines_api(code):
    print('united_lines_api=====')
    layer_tables = geometry_columns('m2023')

    #features = all_line_geojson('m2023', 'branch_line', 3857) # 4326
    #features = all_line_geojson('m2023', 'sub_line', 3857) # 4326
    #print(features)

    all_features = []
    for layer_table in layer_tables:
        features = all_line_geojson(layer_table['f_table_schema'], layer_table['f_table_name'], 3857) # 4326
        all_features += features
        print(layer_table)

    pprint(all_features)
    print('united_lines_api=====' + str(len(all_features)))

    feature_collection = {
        'type': 'FeatureCollection',
        'features': all_features,
        'crs': {
            'type': 'name',
            'properties': {
                'name': 'EPSG:3857',
            },
        },
    }
    return feature_collection
