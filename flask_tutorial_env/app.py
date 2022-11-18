from flask import Flask

app = Flask(__name__)

# 最小構成
@app.route("/") # routeデコーダでrouting
def index(): # view関数、デフォルトのコンテンツタイプはhtml
    # ヒアドキュメント
    s = '''
<p>Hello, World!</p>
<p>hihi</p>'''
    return s


# エスケープ処理
from markupsafe import escape

@app.route("/<name>")
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