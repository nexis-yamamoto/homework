from flask import Blueprint

# 1パラ目はendpointのモジュールnamespace?
ok_module = Blueprint("bpsample", __name__)

@ok_module.route("/bp/ok", methods=["GET"])
def get_ok():
    return "OK"
