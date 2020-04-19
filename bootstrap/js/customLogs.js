function changeType(element) {
    var htmlSection = document.getElementById('typeContent');
    document.getElementById('secondLocalFile').innerHTML = "";
    htmlSection.innerHTML = "";
    switch (element.options[element.selectedIndex].value) {
        case 'command':
            generateCommandHTML(htmlSection);
            break;
        case 'localFile':
            generateLocalFileHTML(htmlSection);
            break;
        case 'response':
            generateResponseHTML(htmlSection);
            break;
    }
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
            <input required type="file" accept=".sh" class="custom-file-input" id="executable" name="` + tags.exe.ossec_name + `">
            <label class="custom-file-label" for="customFile">Choose .sh file</label>
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
        <select id="` + tags.timeout.name + `" class="custom-select" name="` + tags.timeout.ossec_name + `">
            <option disabled selected value="">Allow</option>
            <option value="yes">Yes</option>
            <option value="no">No</option>
        </select>
    </div>`;

    element.innerHTML = html;

}
// https://www.php.net/manual/es/function.shell-exec.php
function generateLocalFileHTML(element) { // Comandos Consola / Ficheros

    html = `
    <div class="input-group mb-3">
        <div class="input-group-prepend">
            <label style="width: 200px;" class="input-group-text" for="inputGroupSelect01">Type Format:</label>
        </div>
        <select required id="" class="custom-select" name="log_format" onchange="generateLocalFileHTMLSecond(this)">
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
                <select required id="dayOrder" class="custom-select" name="dayOrder">
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
                <select required id="dayOrder" class="custom-select" name="dayOrder">
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
                    <input required type="file" accept=".log" class="custom-file-input" id="customFile" name="` + tags.location.ossec_name + `">
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

}

function generateResponseHTML(element) {

    var allowedFormats = [
        "disabled",
        "command",
        "location",
        "agent_id",
        "level",
        "timeout"
    ];

    var allowedNames = [
        "Disabled",
        "Command",
        "Location",
        "Agent_id",
        "Level",
        "Timeout"
    ];

    var allowedLocationFormat = [
        "local",
        "server",
        "defined-agent",
        "all",
    ];


    html = `
    <div class="input-group mb-3">
        <div class="input-group-prepend">
            <label style="width: 200px;" class="input-group-text" for="inputGroupSelect01">` + allowedNames[0] + `: </label>
        </div>
        <select id="dayOrder" class="custom-select" name="dayOrder">
                    <option value select="no">No</option>
                    <option value="yes">Yes</option>
        </select>
    </div>
    <br>
    <div class="input-group mb-3">
        <div class="input-group-prepend">
            <label style="width: 200px;" class="input-group-text" for="inputGroupSelect01">` + allowedNames[1] + `: </label>
        </div>
        <div class="custom-file">
            <input required id="maxDays" type="text" class="form-control" name="" value="">
        </div>
    </div>
    <br>
    <div class="input-group mb-3">
        <div class="input-group-prepend">
            <label style="width: 200px;" class="input-group-text" for="inputGroupSelect01">` + allowedNames[2] + `: </label>
        </div>
        <select required id="dayOrder" class="custom-select" name="dayOrder">
            <option disabled selected value="">Select a type</option>
            <option value="` + allowedLocationFormat[0] + `">Local</option>
            <option value="` + allowedLocationFormat[1] + `">Server</option>
            <option value="` + allowedLocationFormat[2] + `">Defined agent</option>
            <option value="` + allowedLocationFormat[3] + `">All</option>
        </select>
    </div>
    <br>
    <div class="input-group mb-3">
        <div class="input-group-prepend">
            <label style="width: 200px;" class="input-group-text" for="inputGroupSelect01">` + allowedNames[3] + `: </label>
        </div>
        <div class="custom-file">
            <input required id="maxDays" type="number" class="form-control" name="" value="">
        </div>
    </div>
    <br>
    <div class="input-group mb-3">
        <div class="input-group-prepend">
            <label style="width: 200px;" class="input-group-text" for="inputGroupSelect01">` + allowedNames[4] + `: </label>
        </div>
        <div class="custom-file">
            <input required id="maxDays" type="number" class="form-control" name="" value="">
        </div>
    </div>
<br>
    <div class="input-group mb-3">
        <div class="input-group-prepend">
            <label style="width: 200px;" class="input-group-text" for="inputGroupSelect01">` + allowedNames[5] + `: </label>
        </div>
        <div class="custom-file">
            <input required id="maxDays" type="number" class="form-control" name="" value="">
        </div>
    </div>
    
    `;

    element.innerHTML = html;

}

$(".custom-file-input").on("change", function() {
    var fileName = $(this).val().split("\\").pop();
    $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
});

// Subir archivo explorador de archivos: https://www.w3schools.com/php/php_file_upload.asp


//UTIL.SH   situado en var/ossec/bin
// como funciona https://www.ossec.net/docs/docs/programs/util.sh.html
/*

#!/bin/sh
# Simple utilities
# Add a new file
# Add a new remote host to be monitored via lynx
# Add a new remote host to be monitored (DNS)
# Add a new command to be monitored
# by Daniel B. Cid - dcid ( at ) ossec.net

ACTION=$1
FILE=$2
FORMAT=$3

if ! [ -e /etc/ossec-init.conf ]; then
    echo OSSEC Manager not found. Exiting...
    exit 1
fi

. /etc/ossec-init.conf

if [ "X$FILE" = "X" ]; then
    echo "$0: addfile <filename> [<format>]"
    echo "$0: addsite <domain>"
    echo "$0: adddns  <domain>"
    #echo "$0: addcommand <command>"
    echo ""
    #echo "Example: $0 addcommand 'netstat -tan |grep LISTEN| grep -v 127.0.0.1'"
    echo "Example: $0 adddns ossec.net"
    echo "Example: $0 addsite dcid.me"
    exit 1;
fi

if [ "X$FORMAT" = "X" ]; then
    FORMAT="syslog"
fi

# Adding a new file
if [ $ACTION = "addfile" ]; then
    # Checking if file is already configured
    grep "$FILE" ${DIRECTORY}/etc/ossec.conf > /dev/null 2>&1
    if [ $? = 0 ]; then
        echo "$0: File $FILE already configured at ossec."
        exit 1;
    fi

    # Checking if file exist
    ls -la $FILE > /dev/null 2>&1
    if [ ! $? = 0 ]; then
        echo "$0: File $FILE does not exist."
        exit 1;
    fi     
    
    echo "
    <ossec_config>
      <localfile>
      <log_format>$FORMAT</log_format>
      <location>$FILE</location>
     </localfile>
   </ossec_config>  
   " >> ${DIRECTORY}/etc/ossec.conf

   echo "$0: File $FILE added.";
   exit 0;            
fi


# Adding a new DNS check
if [ $ACTION = "adddns" ]; then
   COMMAND="host -W 5 -t NS $FILE; host -W 5 -t A $FILE | sort"
   echo $FILE | grep -E '^[a-z0-9A-Z.-]+$' >/dev/null 2>&1
   if [ $? = 1 ]; then
      echo "$0: Invalid domain: $FILE"
      exit 1;
   fi

   grep "host -W 5 -t NS $FILE" ${DIRECTORY}/etc/ossec.conf >/dev/null 2>&1
   if [ $? = 0 ]; then
       echo "$0: Already configured for $FILE"
       exit 1;
   fi

   MYERR=0
   echo "
   <ossec_config>
   <localfile>
     <log_format>full_command</log_format>
     <command>$COMMAND</command>
   </localfile>
   </ossec_config>
   " >> ${DIRECTORY}/etc/ossec.conf || MYERR=1;

   if [ $MYERR = 1 ]; then
       echo "$0: Unable to modify the configuration file."; 
       exit 1;
   fi

   FIRSTRULE="150010"
   while [ 1 ]; do
       grep "\"$FIRSTRULE\"" ${DIRECTORY}/rules/local_rules.xml > /dev/null 2>&1
       if [ $? = 0 ]; then
           FIRSTRULE=`expr $FIRSTRULE + 1`
       else
           break;
       fi
   done


   echo "
   <group name=\"local,dnschanges,\">
   <rule id=\"$FIRSTRULE\" level=\"0\">
     <if_sid>530</if_sid>
     <check_diff />
     <match>^ossec: output: 'host -W 5 -t NS $FILE</match>
     <description>DNS Changed for $FILE</description>
   </rule>
   </group>
   " >> ${DIRECTORY}/rules/local_rules.xml || MYERR=1;

   if [ $MYERR = 1 ]; then
       echo "$0: Unable to modify the local rules file.";
       exit 1;
   fi

   echo "Domain $FILE added to be monitored."
   exit 0;
fi


# Adding a new lynx check
if [ $ACTION = "addsite" ]; then
   COMMAND="lynx --connect_timeout 10 --dump $FILE | head -n 10"
   echo $FILE | grep -E '^[a-z0-9A-Z.-]+$' >/dev/null 2>&1
   if [ $? = 1 ]; then
      echo "$0: Invalid domain: $FILE"
      exit 1;
   fi

   grep "lynx --connect_timeout 10 --dump $FILE" ${DIRECTORY}/etc/ossec.conf >/dev/null 2>&1
   if [ $? = 0 ]; then
       echo "$0: Already configured for $FILE"
       exit 1;
   fi

   MYERR=0
   echo "
   <ossec_config>
   <localfile>
     <log_format>full_command</log_format>
     <command>$COMMAND</command>
   </localfile>
   </ossec_config>
   " >> ${DIRECTORY}/etc/ossec.conf || MYERR=1;

   if [ $MYERR = 1 ]; then
       echo "$0: Unable to modify the configuration file."; 
       exit 1;
   fi

   FIRSTRULE="150010"
   while [ 1 ]; do
       grep "\"$FIRSTRULE\"" ${DIRECTORY}/rules/local_rules.xml > /dev/null 2>&1
       if [ $? = 0 ]; then
           FIRSTRULE=`expr $FIRSTRULE + 1`
       else
           break;
       fi
   done


   echo "
   <group name=\"local,sitechange,\">
   <rule id=\"$FIRSTRULE\" level=\"0\">
     <if_sid>530</if_sid>
     <check_diff />
     <match>^ossec: output: 'lynx --connect_timeout 10 --dump $FILE</match>
     <description>DNS Changed for $FILE</description>
   </rule>
   </group>
   " >> ${DIRECTORY}/rules/local_rules.xml || MYERR=1;

   if [ $MYERR = 1 ]; then
       echo "$0: Unable to modify the local rules file.";
       exit 1;
   fi

   echo "Domain $FILE added to be monitored."
   exit 0;
fi




*/