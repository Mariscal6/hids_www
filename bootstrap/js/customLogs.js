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

    var allowedFormats = [
        "name", //elige el usuario el nombre
        "executable", //It must be a file (with exec permissions) inside “/var/ossec/active-response/bin”. You don’t need to provide the whole path.
        "expect", //The arguments this command is expecting (options are srcip and username).
        "timeout_allowed", //Specifies if this command supports timeout. Yes or No
    ];

    var allowedNames = [
        "Name",
        "Executable",
        "Expect",
        "Timeout allowed",
    ];

    html =`
    <div class="input-group mb-3">
        <div class="input-group-prepend">
            <label style="width: 200px;" class="input-group-text" for="inputGroupSelect01">`+allowedNames[0]+`: </label>
        </div>
        <input required id="name" type="text" class="form-control" name="`+allowedNames[0]+`" value="">
    </div>
    <br>
    <div class="input-group mb-3">
        <div class="input-group-prepend">
            <label style="width: 200px;" class="input-group-text" for="inputGroupSelect01">`+allowedNames[1]+`: </label>
        </div>
        <div class="custom-file">
            <input required type="file" accept=".sh" class="custom-file-input" id="executable" name="`+allowedNames[1]+`">
            <label class="custom-file-label" for="customFile">Choose .sh file</label>
        </div>
    </div>
    <br>
    <div class="input-group mb-3">
        <div class="input-group-prepend">
            <label style="width: 200px;" class="input-group-text" for="inputGroupSelect01">`+allowedNames[2]+`: </label>
        </div>
        <select id="`+allowedNames[2]+`" class="custom-select" name="`+allowedNames[2]+`">
            <option disabled selected value="">Select a type</option>
            <option value="srcip">srcip</option>
            <option value="user">username</option>
        </select>
    </div>
    <br>
    <div class="input-group mb-3">
    <div class="input-group-prepend">
            <label style="width: 200px;" class="input-group-text" for="inputGroupSelect01">`+allowedNames[3]+`: </label>
        </div>
        <select id="`+allowedNames[3]+`" class="custom-select" name="`+allowedNames[3]+`">
            <option disabled selected value="">Allow</option>
            <option value="yes">Yes</option>
            <option value="no">No</option>
        </select>
    </div>`;

    element.innerHTML = html;

}
// https://www.php.net/manual/es/function.shell-exec.php
function generateLocalFileHTML(element) { // Comandos Consola / Ficheros

    var allowedLogName = [
        "Syslog",
        "Snort Full",
        "Snort Fast",
        "Mysql",
        "Mysql Log",
        "Nmapg",
        "Apache",
        "Command",
        "Full Command",
        "Multiline",
        "Multiline Indented"
    ];

    var allowedFormats = [
        "location",
        "log_format",
        "command",
        "alias",
        "frequency",
        "check_diff",
        "only-future-events"
    ];

    var allowedNames = [
        "Location",
        "Log Format",
        "Command",
        "Alias",
        "Frequency",
        "Check Diff",
        "Only Future Events"
    ];

    var allowedLogFormat = [
        "syslog",
        "snort-full",
        "snort-fast",
        "mysql_log",
        "nmapg",
        "apache",
        "command",
        "full_command",
        "multi-line",
        "multi-line_indented"
    ];


    html = `
    <div class="input-group mb-3">
        <div class="input-group-prepend">
            <label style="width: 200px;" class="input-group-text" for="inputGroupSelect01">Log Format:</label>
        </div>
        <select required id="" class="custom-select" name="log_format" onchange="generateLocalFileHTMLSecond(this)">
            <option disabled selected value="">Log Format</option>
            <option value="command">Command</option>
            <option value="file">File</option>
        </select>
    </div>
    `;

    element.innerHTML = html;
    
}

function generateLocalFileHTMLSecond(element) { // Comandos Consola / Ficheros


    var allowedLogFormat = [
        "syslog",
        "snort-full",
        "snort-fast",
        "mysql_log",
        "nmapg",
        "apache",
        "command",
        "full_command",
        "multi-line",
        "multi-line_indented"
    ];


    var htmlSection = document.getElementById('secondLocalFile');
    htmlSection.innerHTML = "";
    switch (element.options[element.selectedIndex].value) {
        case 'command':
            htmlSection.innerHTML = `

            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <label style="width: 200px;" class="input-group-text" for="inputGroupSelect01">Log Format value: </label>
                </div>
                <select required id="dayOrder" class="custom-select" name="dayOrder">
                    <option disabled selected value="">Select a type</option>
                    <option value="`+allowedLogFormat[6]+`">Command</option>
                    <option value="`+allowedLogFormat[7]+`">Full command</option>
                </select>
            </div>
            
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <label style="width: 200px;" class="input-group-text" for="inputGroupSelect01">Command: </label>
                </div>
                <input required  id="maxDays" type="text" class="form-control" name="" value="">
            </div>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <label style="width: 200px;" class="input-group-text" for="inputGroupSelect01">Alias: </label>
                </div>
                <input id="maxDays" type="text" class="form-control" name="" value="">
            </div>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <label style="width: 200px;" class="input-group-text" for="inputGroupSelect01">Frequency: </label>
                </div>
                <input id="maxDays" type="number" min="0" class="form-control" name="" value="">
            </div>`;
        break;
        case 'file':
            htmlSection.innerHTML = `

            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <label style="width: 200px;" class="input-group-text" for="inputGroupSelect01">Log Format value: </label>
                </div>
                <select required id="dayOrder" class="custom-select" name="dayOrder">
                    <option value="`+allowedLogFormat[0]+` selected">Syslog</option>
                    <option value="`+allowedLogFormat[1]+`">Snort full</option>
                    <option value="`+allowedLogFormat[2]+`">Snort fast</option>
                    <option value="`+allowedLogFormat[3]+`">Mysql log</option>
                    <option value="`+allowedLogFormat[4]+`">Nmapg</option>
                    <option value="`+allowedLogFormat[5]+`">Apache</option>
                    <option value="`+allowedLogFormat[8]+`">Multi line</option>
                    <option value="`+allowedLogFormat[9]+`">Multi line indented</option>
                </select>
            </div>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <label style="width: 200px;" class="input-group-text" for="inputGroupSelect01">Location: </label>
                </div>
                <div class="custom-file">
                    <input required type="file" accept=".log" class="custom-file-input" id="customFile">
                    <label class="custom-file-label" for="customFile">Choose .log file</label>
                </div>
            </div>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <label style="width: 200px;" class="input-group-text" for="inputGroupSelect01">Check Diff: </label>
                </div>
                <select id="dayOrder" class="custom-select" name="dayOrder">
                    <option disabled selected value="">Allow</option>
                    <option value="yes">Yes</option>
                    <option value="no">No</option>
                </select>
            </div>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <label style="width: 200px;" class="input-group-text" for="inputGroupSelect01">Only Future Events: </label>
                </div>
                <select id="dayOrder" class="custom-select" name="dayOrder">
                    <option disabled selected value="">Allow</option>
                    <option value="yes">Yes</option>
                    <option value="no">No</option>
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


    html =`
    <div class="input-group mb-3">
        <div class="input-group-prepend">
            <label style="width: 200px;" class="input-group-text" for="inputGroupSelect01">`+allowedNames[0]+`: </label>
        </div>
        <select id="dayOrder" class="custom-select" name="dayOrder">
                    <option value select="no">No</option>
                    <option value="yes">Yes</option>
        </select>
    </div>
    <br>
    <div class="input-group mb-3">
        <div class="input-group-prepend">
            <label style="width: 200px;" class="input-group-text" for="inputGroupSelect01">`+allowedNames[1]+`: </label>
        </div>
        <div class="custom-file">
            <input required id="maxDays" type="text" class="form-control" name="" value="">
        </div>
    </div>
    <br>
    <div class="input-group mb-3">
        <div class="input-group-prepend">
            <label style="width: 200px;" class="input-group-text" for="inputGroupSelect01">`+allowedNames[2]+`: </label>
        </div>
        <select required id="dayOrder" class="custom-select" name="dayOrder">
            <option disabled selected value="">Select a type</option>
            <option value="`+allowedLocationFormat[0]+`">Local</option>
            <option value="`+allowedLocationFormat[1]+`">Server</option>
            <option value="`+allowedLocationFormat[2]+`">Defined agent</option>
            <option value="`+allowedLocationFormat[3]+`">All</option>
        </select>
    </div>
    <br>
    <div class="input-group mb-3">
        <div class="input-group-prepend">
            <label style="width: 200px;" class="input-group-text" for="inputGroupSelect01">`+allowedNames[3]+`: </label>
        </div>
        <div class="custom-file">
            <input required id="maxDays" type="number" class="form-control" name="" value="">
        </div>
    </div>
    <br>
    <div class="input-group mb-3">
        <div class="input-group-prepend">
            <label style="width: 200px;" class="input-group-text" for="inputGroupSelect01">`+allowedNames[4]+`: </label>
        </div>
        <div class="custom-file">
            <input required id="maxDays" type="number" class="form-control" name="" value="">
        </div>
    </div>
<br>
    <div class="input-group mb-3">
        <div class="input-group-prepend">
            <label style="width: 200px;" class="input-group-text" for="inputGroupSelect01">`+allowedNames[5]+`: </label>
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