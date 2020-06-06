function changeType(element) {

    var htmlSection = document.getElementById('typeContent');

    document.getElementById('secondLocalFile').innerHTML = "";

    htmlSection.innerHTML = "";

    document.getElementById('submitRules').disabled = false;

    switch (element.options[element.selectedIndex].value) {

        case 'command':

            generateCommandHTML(htmlSection);

            break;

        case 'localFile':

            generateLocalFileHTML(htmlSection);

            break;

        case 'dns':

            generateDNSHTML(htmlSection);

            break;

        case 'website':

            generateWebsiteHTML(htmlSection);

            break;



            //case 'response':

            //    generateResponseHTML(htmlSection);

            //    break;

    }

}

function generateDNSHTML(element) {



    var tags = {

        "dns": {

            "name": "Dns",

            "info": "Monitor the name server of a domain for changes.",

            "ossec_name": "dns"

        }

    };



    html = `

    <div class="input-group mb-3">

        <div class="input-group-prepend">

            <label style="width: 200px;" class="input-group-text" for="inputGroupSelect01">

            <i class="fas fa-info-circle" title="` + tags.dns.info + `" style="margin-right:6px;"></i>

            ` + tags.dns.name + `: 

            </label>

        </div>

        <input required id="name" type="text" class="form-control" name="` + tags.dns.ossec_name + `" value="">

       

    </div>`;



    element.innerHTML = html;

}

function generateWebsiteHTML(element) {



    var tags = {

        "website": {

            "name": "Website",

            "info": "Monitor a website for changes.",

            "ossec_name": "website"

        }

    };



    html = `

    <div class="input-group mb-3">

        <div class="input-group-prepend">

            <label style="width: 200px;" class="input-group-text" for="inputGroupSelect01">

            <i class="fas fa-info-circle" title="` + tags.website.info + `" style="margin-right:6px;"></i>

            ` + tags.website.name + `: 

            </label>

        </div>

        <input required id="name" type="text" class="form-control" name="` + tags.website.ossec_name + `" value="">

    </div>`;



    element.innerHTML = html;



}

function generateCommandHTML(element) {



    var tags = {

        "name": {

            "name": "Name",
            "info": "Used to link the command to the response.",
            "ossec_name": "name"

        },

        "exe": {

            "name": "Executable",
            "info": "It must be a file (with exec permissions) inside “/var/ossec/active-response/bin”. You don’t need to provide the whole path.",
            "ossec_name": "executable"

        },

        "expect": {

            "name": "Expect",
            "info": "The arguments this command is expecting (options are srcip and username).",
            "ossec_name": "expect"

        },

        "timeout": {

            "name": "Timeout allowed",
            "info": "Specifies if this command supports timeout. Yes or No",
            "ossec_name": "timeout_allowed"

        },

        "response_active": {
            "name": "Response Active",
            "info": "Specifies if this command supports timeout. Yes or No",
            "ossec_name": "response_active"

        },



    };

    var allowedNames = [

        "Name",

        "Executable",

        "Expect",

        "Timeout allowed",

    ];



    html = `

    <div class="input-group mb-3">

        <div class="input-group-prepend">

            <label style="width: 200px;" class="input-group-text" for="inputGroupSelect01">

            <i class="fas fa-info-circle" title="` + tags.name.info + `" style="margin-right:6px;"></i>

            ` + tags.name.name + `: 

            </label>

        </div>

        <input required id="name" type="text" class="form-control" name="` + tags.name.ossec_name + `" value="">

    </div>

    <br>

    <div class="input-group mb-3">

        <div class="input-group-prepend">

            <label style="width: 200px;" class="input-group-text" for="inputGroupSelect01">

                <i class="fas fa-info-circle" title="` + tags.exe.info + `" style="margin-right:6px;"></i>

                  ` + tags.exe.name + `: 

            </label>

        </div>

        <div class="custom-file">

            <input required type="file" accept=".sh" class="custom-file-input" id="executable" name="` + tags.exe.ossec_name + `[]" multiple>

            <label id="files_names" class="custom-file-label" for="customFile">Choose .sh file</label>

        </div>

    </div>

    <br>

    <div class="input-group mb-3">

        <div class="input-group-prepend">

            <label style="width: 200px;" class="input-group-text" for="inputGroupSelect01">

            <i class="fas fa-info-circle" title="` + tags.expect.info + `" style="margin-right:6px;"></i>

            ` + tags.expect.name + `: 

            </label>

        </div>

        <select id="` + tags.expect.ossec_name + `" class="custom-select" name="` + tags.expect.ossec_name + `">

            <option disabled selected value="">Select a type</option>

            <option value="srcip">srcip</option>

            <option value="user">username</option>

        </select>

    </div>

    <br>

    <div class="input-group mb-3">

        <div class="input-group-prepend">

            <label style="width: 200px;" class="input-group-text" for="inputGroupSelect01">

                <i class="fas fa-info-circle" title="` + tags.timeout.info + `" style="margin-right:6px;"></i>

            ` + tags.timeout.name + `: 

            </label>

        </div>

        <select id="` + tags.timeout.name + `" class="custom-select" name="` + tags.timeout.ossec_name + `" style="width: 200px;border-bottom-right-radius: 0.3em; border-top-right-radius: 0.3em;">

            <option disabled selected value="">Allow</option>
            <option value="yes">Yes</option>
            <option value="no">No</option>

        </select>

        <div class="input-group-prepend ml-2 ">

            <label style="width: 200px;border-bottom-left-radius: 0.3em; border-top-left-radius: 0.3em;" class="input-group-text" for="inputGroupSelect01">Active Response:</label>

         </div>
        
        <select required id="active_response" class="custom-select" name="active_response" onchange="generateCommandHTMLSecond(this)">

            <option disabled selected value="">Active Response</option>
            <option value="yes">Yes</option>
            <option value="no">No</option>

        </select>

    </div>`;



    element.innerHTML = html;
    changeInputFile();

}

function generateCommandHTMLSecond(element) {

    var tags = {

        "disabled": {
            "name": "Disabled",
            "info": "Disables the active response capabilities if set to yes. If this is set, active response will not work.",
            "ossec_name": "disabled"
        },

        "location": {
            "name": "Location",
            "info": "Where the command should be executed. You have four options:local,server,defined-agent,all",
            "ossec_name": "location"
        },

        "rules_id": {
            "name": "Rules id",
            "info": "Comma separated list of rules id (0-9)",
            "ossec_name": "rules_id"
        },
        "level": {
            "name": "Level",
            "info": "The response will be executed on any event with this level or higher",
            "ossec_name": "level"
        },
    }
    var propsLocation = {

        "local": {
            "name": "Local",
            "ossec_name": "local"
        },
        "server": {
            "name": "Server",
            "ossec_name": "server"
        },
        "definedagent": {
            "name": "Defined agent",
            "ossec_name": "defined-agent"
        },
        "all": {
            "name": "All",
            "ossec_name": "all"
        }
    }


    var htmlSection = document.getElementById('secondLocalFile');

    switch (element.options[element.selectedIndex].value) {

        case 'yes':

            htmlSection.innerHTML = `

            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <label style="width: 200px;" class="input-group-text" for="inputGroupSelect01">
                        <i class="fas fa-info-circle" title="` + tags.disabled.info + `" style="margin-right:6px;"></i> ` + tags.disabled.name + ` : 
                    </label>
                </div>

                <select required id="disabled" class="custom-select" name="disabled">
                    <option disabled selected value="">Allow</option>
                    <option value="yes">Yes</option>
                    <option value="no">No</option>
                </select>

            </div>

            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <label style="width: 200px;" class="input-group-text" for="inputGroupSelect01">
                    <i class="fas fa-info-circle" title="` + tags.location.info + `" style="margin-right:6px;"></i>
                    ` + tags.location.name + ` :
                    </label>
                </div>

                <select required id="dayOrder" class="custom-select" name="location">
                    <option select value="` + propsLocation.local.ossec_name + `"> ` + propsLocation.local.name + `</option>
                    <option value="` + propsLocation.server.ossec_name + `">` + propsLocation.server.name + `</option>
                    <option value="` + propsLocation.definedagent.ossec_name + `">` + propsLocation.definedagent.name + `</option>
                    <option value="` + propsLocation.all.ossec_name + `">` + propsLocation.all.name + `</option>
                </select>

            </div>

            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <label style="width: 200px;" class="input-group-text" for="inputGroupSelect01">
                        <i class="fas fa-info-circle" title="` + tags.rules_id.info + `" style="margin-right:6px;"></i>
                    ` + tags.rules_id.name + ` : 
                    </label>
                </div>
                <input required id="maxDays" type="number" min="0" class="form-control" name="` + tags.rules_id.ossec_name + `" value="">
            </div>

            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <label style="width: 200px;" class="input-group-text" for="inputGroupSelect01">
                        <i class="fas fa-info-circle" title="` + tags.level.info + `" style="margin-right:6px;"></i>
                    ` + tags.level.name + ` : 
                    </label>
                </div>
                <input required id="maxDays" type="number" min="0" class="form-control" name="` + tags.level.ossec_name + `" value="">
            </div>
            `;

            break;
        case 'no':
            htmlSection.innerHTML = "";

    }



}

// https://www.php.net/manual/es/function.shell-exec.php

function generateLocalFileHTML(element) { // Comandos Consola / Ficheros

    html = `

    <div class="input-group mb-3">

        <div class="input-group-prepend">

            <label style="width: 200px;" class="input-group-text" for="inputGroupSelect01">Type Format:</label>

        </div>

        <select required id="" class="custom-select" name="type_format" onchange="generateLocalFileHTMLSecond(this)">

            <option disabled selected value="">Type Format</option>

            <option value="command">Command</option>

            <option value="file">File</option>

        </select>

    </div>

    `;



    element.innerHTML = html;



}

function generateLocalFileHTMLSecond(element) { // Comandos Consola / Ficheros

    var tags = {

        "location": {

            "name": "Location",

            "info": "Specify the location of the log to be read. strftime formats may be used for log file names",

            "ossec_name": "location"

        },

        "format": {

            "name": "Log format",

            "info": "The format of the log being read.",

            "ossec_name": "log_format"

        },

        "command": {

            "name": "Command",

            "info": "The command to be run. All output from this command will be read as one or more log messages",

            "ossec_name": "command"

        },

        "alias": {

            "name": "Alias",

            "info": "An alias to identify the command. This will replace the command in the log message.",

            "ossec_name": "alias"

        },

        "frequency": {

            "name": "Frequency",

            "info": "The minimum time in seconds between command runs",

            "ossec_name": "frequency"

        },

        "diff": {

            "name": "Check diff",

            "info": "The output from an event will be stored in an internal database",

            "ossec_name": "check_diff"

        },

        "future": {

            "name": "Only future events",

            "info": "Only used with the eventchannel log format. By default, when OSSEC starts the eventchannel log format will read all events that ossec-logcollector missed since it was last stopped",

            "ossec_name": "only-future-events"

        },



    }

    var propsLogFormat = {

        "syslog": {

            "name": "Syslog",

            "ossec_name": "syslog"

        },

        "snortfull": {

            "name": "Snort full",

            "ossec_name": "snort-full"

        },

        "snortfast": {

            "name": "Snort fast",

            "ossec_name": "snort-fast"

        },

        "mysql": {

            "name": "Mysql",

            "ossec_name": "mysql_log"

        },

        "nmapg": {

            "name": "Nmapg",

            "ossec_name": "nmapg"

        },

        "apache": {

            "name": "Apache",

            "ossec_name": "apache"

        },

        "command": {

            "name": "Command",

            "ossec_name": "command"

        },

        "fullcommand": {

            "name": "Full command",

            "ossec_name": "full_command"

        },

        "multiline": {

            "name": "Multi line",

            "ossec_name": "multi-line"

        },

        "multilineindented": {

            "name": "Multi line indented",

            "ossec_name": "multi-line_indented"

        }

    }

    var htmlSection = document.getElementById('secondLocalFile');

    htmlSection.innerHTML = "";

    switch (element.options[element.selectedIndex].value) {

        case 'command':

            htmlSection.innerHTML = `

            <div class="input-group mb-3">

                <div class="input-group-prepend">

                    <label style="width: 200px;" class="input-group-text" for="inputGroupSelect01">

                        <i class="fas fa-info-circle" title="` + tags.format.info + `" style="margin-right:6px;"></i>

                    ` + tags.format.name + ` : 

                    </label>

                </div>

                <select required id="dayOrder" class="custom-select" name="logFormat">

                    <option value="` + propsLogFormat.command.ossec_name + `">` + propsLogFormat.command.name + `</option>

                    <option selected value="` + propsLogFormat.fullcommand.ossec_name + `">` + propsLogFormat.fullcommand.name + `</option>

                </select>

            </div>

            

            <div class="input-group mb-3">

                <div class="input-group-prepend">

                    <label style="width: 200px;" class="input-group-text" for="inputGroupSelect01">

                        <i class="fas fa-info-circle" title="` + tags.command.info + `" style="margin-right:6px;"></i>

                    ` + tags.command.name + ` :

                    </label>

                </div>

                <input required  id="maxDays" type="text" class="form-control" name="` + tags.command.ossec_name + `" value="">

            </div>

            <div class="input-group mb-3">

                <div class="input-group-prepend">

                    <label style="width: 200px;" class="input-group-text" for="inputGroupSelect01">

                    <i class="fas fa-info-circle" title="` + tags.alias.info + `" style="margin-right:6px;"></i>

                    ` + tags.alias.name + ` :

                    </label>

                </div>

                <input id="maxDays" type="text" class="form-control" name="` + tags.alias.ossec_name + `" value="">

            </div>

            <div class="input-group mb-3">

                <div class="input-group-prepend">

                    <label style="width: 200px;" class="input-group-text" for="inputGroupSelect01">

                        <i class="fas fa-info-circle" title="` + tags.frequency.info + `" style="margin-right:6px;"></i>

                    ` + tags.frequency.name + ` : 

                    </label>

                </div>

                <input id="maxDays" type="number" min="0" class="form-control" name="` + tags.frequency.ossec_name + `" value="">

            </div>`;

            break;



        case 'file':

            htmlSection.innerHTML = `



            <div class="input-group mb-3">

                <div class="input-group-prepend">

                    <label style="width: 200px;" class="input-group-text" for="inputGroupSelect01">

                        <i class="fas fa-info-circle" title="` + tags.format.info + `" style="margin-right:6px;"></i>

                    ` + tags.format.name + `: 

                    </label>

                </div>

                <select required id="dayOrder" class="custom-select" name="logFormat">

                    <option select value="` + propsLogFormat.syslog.ossec_name + `"> ` + propsLogFormat.syslog.name + `</option>

                    <option value="` + propsLogFormat.snortfull.ossec_name + `">` + propsLogFormat.snortfull.name + `</option>

                    <option value="` + propsLogFormat.snortfast.ossec_name + `">` + propsLogFormat.snortfast.name + `</option>

                    <option value="` + propsLogFormat.mysql.ossec_name + `">` + propsLogFormat.mysql.name + `</option>

                    <option value="` + propsLogFormat.nmapg.ossec_name + `">` + propsLogFormat.nmapg.name + `</option>

                    <option value="` + propsLogFormat.apache.ossec_name + `">` + propsLogFormat.apache.name + `</option>

                    <option value="` + propsLogFormat.multiline.ossec_name + `">` + propsLogFormat.multiline.name + `</option>

                    <option value="` + propsLogFormat.multilineindented.ossec_name + `">` + propsLogFormat.multilineindented.name + `</option>

                </select>

            </div>

            <div class="input-group mb-3">

                <div class="input-group-prepend">

                    <label style="width: 200px;" class="input-group-text" for="inputGroupSelect01">

                        <i class="fas fa-info-circle" title="` + tags.location.info + `" style="margin-right:6px;"></i>

                    ` + tags.location.name + `: 

                    </label>

                </div>

                <div class="custom-file">

                    <input required type="file" accept=".log" class="custom-file-input" id="customFile" name="` + tags.location.ossec_name + `[]" multiple>

                    <label class="custom-file-label" for="customFile">Choose .log file</label>

                </div>

            </div>

            <div class="input-group mb-3">

                <div class="input-group-prepend">

                    <label style="width: 200px;" class="input-group-text" for="inputGroupSelect01">

                        <i class="fas fa-info-circle" title="` + tags.diff.info + `" style="margin-right:6px;"></i>

                    ` + tags.diff.name + `: 

                    </label>

                </div>

                <select id="dayOrder" class="custom-select" name="` + tags.diff.ossec_name + `">

                    <option selected value="yes">Yes</option>

                    <option value="no">No</option>

                </select>

            </div>

            <div class="input-group mb-3">

                <div class="input-group-prepend">

                    <label style="width: 200px;" class="input-group-text" for="inputGroupSelect01">

                        <i class="fas fa-info-circle" title="` + tags.future.info + `" style="margin-right:6px;"></i>

                    ` + tags.future.name + `: 

                    </label>

                </div>

                <select id="dayOrder" class="custom-select" name="` + tags.future.ossec_name + `">

                    <option value="yes">Yes</option>

                    <option selected value="no">No</option>

                </select>

            </div>

            

            `;

            break;

    }
    changeInputFile();

}

$(".custom-file-input").on("change", function() {

    var fileName = $(this).val().split("\\").pop();

    $(this).siblings(".custom-file-label").addClass("selected").html(fileName);

});

function changeInputFile() {
    $('input[type=file]').change(function() {
        $('files_names').text;
    });
}