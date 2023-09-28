from flask import Flask

app = Flask(__name__)

# fromのファイル名に予約語や既存クラス名はつかえない
from subprocess_sample import command_module
from blueprint_sample import sample_module

app.register_blueprint(command_module)
app.register_blueprint(sample_module)

# 最小構成
@app.route("/") # routeデコーダでrouting
def index(): # view関数、デフォルトのコンテンツタイプはhtml
    # ヒアドキュメント
    s = '''
<p>Hello, World!</p>
<a href="/list-routes">all routes</p>
<a href="/me">json</p>
<a href="/version">psycopg2</p>
<a href="/leaflet/5154">5154 farmer map</p>
'''
    return s


# エスケープ処理
from markupsafe import escape

@app.route("/hello/<name>")
def hello(name):
    return f"Hello, {escape(name)}!"

# 変数を含むurl(文字列) <>で囲んで名前をつける
@app.route('/user/<username>')
def show_user_profile(username):
    # show the user profile for that user
    # pythonのf文字列はフォーマットする
    return f'User {escape(username)}'

# 変数含むurl(コンバータ使用)
@app.route('/post/<int:post_id>')
def show_post(post_id):
    # show the post with the given id, the id is an integer
    # int以外の場合404 not foundとなる
    return f'Post {post_id}'

@app.route('/path/<path:subpath>')
def show_subpath(subpath):
    # show the subpath after /path/
    return f'Subpath {escape(subpath)}'


# 末尾/の扱い
# projectsをprojects/にリダイレクト
@app.route('/projects/')
def projects():
    return 'The project page'

# about/は404
@app.route('/about')
def about():
    return 'The about page'


# view関数名からルートパスの逆引きurl_for
from flask import url_for

@app.route('/logon')
def logon():
    return 'logon'

@app.route('/user/<username>')
def profile(username):
    return f'{username}\'s profile'

@app.route('/for')
def urls():
    # ログ出力
    print(url_for('hello_world'))
    print(url_for('logon'))
    print(url_for('logon', next='/'))
    print(url_for('profile', username='John Doe'))
    return 'urls'


# requestをつかってHTTPメソッド判定
from flask import request

@app.route('/login', methods=['GET', 'POST'])
def login():
    if request.method == 'POST':
        return 'logined'
    else:
        return '<form action="/login" method="POST"><button type=submit>go</button></form>'

# テンプレートで
# Flaskはテンプレートをtemplatesフォルダの中から探します。
#url_for('static', filename='style.css')
from flask import render_template

@app.route('/template/')
@app.route('/template/<name>')
def first(name=None):
    return render_template('first.html', name=name)


# セッション
from flask import session

# Set the secret key to some random bytes. Keep this really secret!
app.secret_key = b'_5#y2L"F4Q8z\n\xec]/'

@app.route('/session/set/<name>')
def setname(name):
    session['name'] = name
    return 'set name'

@app.route('/session/show')
def showname():
    print(type(session));
    return f'session {session["name"]}'


# フラッシュメッセージ
from flask import flash
from flask import get_flashed_messages

@app.route('/flash/out')
def flashout():
    # メッセージを配列で一括取り出し。メッセージは取り出すとクリアされる
    return get_flashed_messages()
    
@app.route('/flash/<message>')
def flashmessage(message):
    flash(escape(message))
    return f'flashed {escape(message)}'


# jSON
# view関数でdictをreturnしたらjson扱いになる
@app.route('/me')
def json_me():
    return {
        'name': 'moge',
        'key': 'hoe',
        'theme': 'black'
    }

@app.route('/log')
def logging():
    app.logger.debug('A value for debugging')
    app.logger.warning('A warning occurred (%d apples)', 42)
    app.logger.error('An error occurred')
    return 'logged'



import psycopg2
@app.route('/version/')
def db_version():
    dsn = "dbname=tracea host=localhost user=postgres"
    conn = psycopg2.connect(dsn)
    cur = conn.cursor()
    cur.execute("select version()")
    r = cur.fetchone()
    cur.close()
    conn.close()
    return f"result {r}"

@app.route('/psycopg2_geojson')
def psycopg2_geojson():
    dsn = "dbname=tracea host=localhost user=postgres"
    conn = psycopg2.connect(dsn)
    cur = conn.cursor()
    cur.execute("select ST_AsGeoJSON(ST_Transform(geometry, 4326)) from hojo_for_histories where year=2022")
    r = cur.fetchone()

    records = []
    for row in cur:
        print(row) # row is tuple
        records += row

    cur.close()
    conn.close()
    return records

import json

def geojson(epsg, farmer_code=5154):
    dsn = "dbname=tracea host=localhost user=postgres"
    hojos = []
    sql = """select
  ST_AsGeoJSON(ST_Transform(geometry, {srs})) as geom,
  h.no, h.subno,
  c.name as crop_name,
  h.farmer_name,
  c.color as color
from hojo_for_histories h
join crops c on (h.crop_code=c.code)
where (year=2022 """.format(srs=epsg)
    if farmer_code == 0:
        sql += ")"
    else:
        sql += "and farmer_code={code})".format(code=farmer_code)
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
                        'no': row[1],
                        'subno': row[2],
                        'crop_name': row[3],
                        'farmer_name': row[4],
                        'color': row[5]
                    }
                }
                #print(feature)
                hojos.append(feature)
    return hojos

@app.route('/leaflet/<int:code>')
def leaflet(code):
    hojos = geojson(4326, farmer_code=code)
    #hojos = geojson(3857)
    return render_template('leaflet.html', hojos=hojos) #, json=hojos_json_string)

@app.route('/openlayers_sample')
def openlayers_sample():
    return render_template('openlayers_sample.html')

@app.route('/openlayers')
def openlayers():
    hojos = geojson(3857)
    return render_template('openlayers.html', geojsons=hojos) #, json=hojos_json_string)

@app.route('/map')
def map():
    hojos = geojson(3857)
    return render_template('map.html', hojos=hojos) #, json=hojos_json_string)

@app.route('/hojos/<int:code>')
def hojos(code):
    features = geojson(3857, code) # 4326
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

from flask import request
#from werkzeug.datastructures import ImmutableMultiDict
import werkzeug

# http://192.168.253.54:5000/get_params/?hoge=huga&moge=piyo&hoge=puyo
# http://192.168.253.54:5000/get_params/?service=WMS&request=GetMap&layers=air&styles=&format=image%2Fpng&transparent=true&version=1.1.1&scheme=wms&continuousWorld=true&width=256&height=256&srs=EPSG%3A3857&bbox=15859766.124834653,5423971.527116109,15860377.621060936,5424583.023342389
@app.route('/get_params/')
def get_params():
    # multidictは同一keyの複数レコードがあるのでリストで取れる
    data = werkzeug.datastructures.ImmutableMultiDict([('input', 'GFG'), ('input', 'Geeks For Geeks')])
    print(data.getlist('input'))
    params = request.args # werkzeug.ImmutableMultiDict is MultiDict
    print(params.keys())
    for key in params.keys():
        print(key, params[key])
        print(key, params.getlist(key))
    return 'params:' + type(params).__name__

import mapscript
from flask import make_response

# http://192.168.253.54:5000/mapscript/?service=WMS&request=GetMap&layers=air&styles=&format=image%2Fpng&transparent=true&version=1.1.1&scheme=wms&continuousWorld=true&width=256&height=256&srs=EPSG%3A3857&bbox=15859766.124834653,5423971.527116109,15860377.621060936,5424583.023342389
"""
service ['WMS']
request ['GetMap']
layers ['air']
styles ['']
format ['image/png']
transparent ['true']
version ['1.1.1']
scheme ['wms']
continuousWorld ['true']
width ['256']
height ['256']
srs ['EPSG:3857']
bbox ['15859766.124834653,5423971.527116109,15860377.621060936,5424583.023342389']
"""
@app.route('/mapscript/')
def mapscript_test():
    params = request.args # werkzeug.ImmutableMultiDict is MultiDict
    print(params.keys())

    req = mapscript.OWSRequest()
    #n = req.loadParams() # 機能せず => -1
    for key in params.keys():
        print(key, params[key])
        print(key, params.getlist(key))
        req.setParameter(key, params[key])
    mapfile = '/srv/tracea/wms_ng.map'
    map = mapscript.mapObj(mapfile)
    mapscript.msIO_installStdoutToBuffer()
    map.OWSDispatch(req)
    content_type = mapscript.msIO_stripStdoutBufferContentType()
    result = mapscript.msIO_getStdoutBufferBytes()

    # ★ポイント1
    response = make_response()

    # レスポンスオブジェクトに画像バイナリを設定
    response.data = result

    # ダウンロード時
    #downloadFileName = 'report3.png'
    #response.headers['Content-Disposition'] = 'attachment; filename=' + downloadFileName

    # ファイルタイプ
    response.mimetype = 'image/png'
    return response




# FlaskアプリケーションのルートとURLルールの一覧を取得
@app.route('/list-routes')
def list_routes():
    routes = []
    for rule in app.url_map.iter_rules():
        print(type(rule))
        print(vars(rule))
        route = {
            'endpoint': rule.endpoint,
            'methods': ','.join(rule.methods),
            'path': rule.rule,
#            'vars': str(vars(rule))
        }
        routes.append(route)
    
    return {'routes': routes}