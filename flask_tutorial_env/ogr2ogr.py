from flask import Blueprint
from flask import render_template
import subprocess

# 1パラ目はendpointのモジュールnamespace?
ogr_module = Blueprint("ogr2ogr", __name__)

#create db on main cluster.

#createdb -U postgres -E UTF-8 map -T template0
#psql -U postgres -d map -c "CREATE EXTENSION postgis;"
#psql -U postgres -d map -c "CREATE EXTENSION postgis_topology;"


# 作付
#ruby -I$RUBYPATH $RUBYPATH/pg_query.rb "drop table tmp_plants"
#ogr2ogr -f "PostgreSQL" -t_srs EPSG:2454 PG:"host=$HOST user=$USER dbname=$DBNAME password=$PASSWORD" tmp_plants.mif -append

# 耕地
#ruby -I$RUBYPATH $RUBYPATH/pg_query.rb "drop table tmp_hojos"
#ogr2ogr -f "PostgreSQL" -t_srs EPSG:2454 PG:"host=$HOST user=$USER dbname=$DBNAME password=$PASSWORD" tmp_hojos.mif -append

# TAB to MIF
# ogr2ogr -f "MapInfo File" #{mif_dir}/#{m[1]}.mif -dsco "FORMAT=MIF" #{path}
# $ ogr2ogr -f "MapInfo File" honsen.mif -dsco "FORMAT=MIF" honsen.TAB


@ogr_module.route("/command/ogr", methods=["GET"])
def exec_ls():
    completed_process = subprocess.run(["ls", "-l"], capture_output=True, encoding="utf-8")
    #error completed_process = subprocess.run(["ls", "-J"], capture_output=True, encoding="utf-8")
    #print(vars(completed_process))
    return_args = completed_process.args
    return_code = completed_process.returncode
    return_stdout = completed_process.stdout
    return_stderr = completed_process.stderr
    # f(ormat)-string
    return f"{return_args} returns {return_code}\n{return_stdout}\n{return_stderr}"

import json
import psycopg2

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


@ogr_module.route('/lines')
def openlayers():
    hojos = line_geojson(3857)
    return render_template('lines.html', geojsons=hojos) #, json=hojos_json_string)


@ogr_module.route('/lines_api/<int:code>')
def lines(code):
    features = line_geojson(3857) # 4326
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
