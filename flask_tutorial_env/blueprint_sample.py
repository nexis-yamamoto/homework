from flask import Blueprint

# 1パラ目はendpointのモジュールnamespace?
sample_module = Blueprint("bpsample", __name__)

@sample_module.route("/bp/ok", methods=["GET"])
def get_ok():
    return "OK"
