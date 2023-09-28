from flask import Blueprint
import subprocess

# 1パラ目はendpointのモジュールnamespace?
command_module = Blueprint("subprocess", __name__)

@command_module.route("/command/ls", methods=["GET"])
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
