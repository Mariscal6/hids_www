function changeType(element) {
    var htmlSection = document.getElementById('typeContent');
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

function changeLogFormat(element) {
    
}

function generateCommandHTML(element) {

    var allowedFormats = [
        "name",
        "executable",
        "expect",
        "timeout_allowed",
    ];

    var allowedNames = [
        "Name",
        "Executable",
        "Expect",
        "Timeout allowed",
    ];


    html =`
    <div class="input-group">
        <div class="input-group-prepend">
            <label style="width: 200px;" class="input-group-text" for="inputGroupSelect01">Type:</label>
        </div>
        <select id="dayOrder" class="custom-select" name="dayOrder" onchange="changeLogFormat(this);">
            <option disabled selected value="">Select a Format</option>`;
    
    for (var i = 0; i < allowedFormats.length; i++) {
        html += `<option value="` + allowedFormats[i] + `">`+ allowedNames[i] + `</option/>`;
    }
            
    html += `</select>
    </div>`;

    element.innerHTML = html;


 
}
// https://www.php.net/manual/es/function.shell-exec.php
function generateLocalFileHTML(element) { // Comandos Consola / Ficheros

    html =`
    <div class="input-group">
        <div class="input-group-prepend">
            <label style="width: 200px;" class="input-group-text" for="inputGroupSelect01">Type:</label>
        </div>
        <select id="dayOrder" class="custom-select" name="dayOrder" onchange="changeLogFormat(this);">
            <option disabled selected value="">Select a Format</option>
            <option disabled selected value="">Select a Format</option>
            <option disabled selected value="">Select a Format</option>
        </select>
    </div>`;
    //Falta meter propiedades grandes 
    var allowedFormats = [
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

    var allowedNames = [
        "Snort Full",
        "Syslog",
        "Snort Fast",
        "Mysql",
        "Nmapg",
        "Apache",
        "Command",
        "Full Command",
        "Multiline",
        "Multiline Indented"
    ];

    
    html =`
    <div class="input-group">
        <div class="input-group-prepend">
            <label style="width: 200px;" class="input-group-text" for="inputGroupSelect01">Type:</label>
        </div>
        <select id="dayOrder" class="custom-select" name="dayOrder" onchange="changeLogFormat(this);">
            <option disabled selected value="">Select a Format</option>`;
    
    for (var i = 0; i < allowedFormats.length; i++) {
        html += `<option value="` + allowedFormats[i] + `">`+ allowedNames[i] + `</option/>`;
    }
            
    html += `</select>
    </div>`;

    element.innerHTML = html;
    
}

function generateResponseHTML(element) {

    var allowedFormats = [
        "disabled",
        "command",
        "location",
        "local",
        "server",
        "defined-agent",
        "all",
        "agent_id",
        "level",
        "timeout"
    ];


    var allowedNames = [
        "Disabled",
        "Command",
        "Location",
        "Local",
        "Server",
        "Defined agent",
        "All",
        "Agent_id",
        "Level",
        "Timeout"
    ];


    html =`
    <div class="input-group">
        <div class="input-group-prepend">
            <label style="width: 200px;" class="input-group-text" for="inputGroupSelect01">Type:</label>
        </div>
        <select id="dayOrder" class="custom-select" name="dayOrder" onchange="changeLogFormat(this);">
            <option disabled selected value="">Select a Format</option>`;
    
    for (var i = 0; i < allowedFormats.length; i++) {
        html += `<option value="` + allowedFormats[i] + `">`+ allowedNames[i] + `</option/>`;
    }
            
    html += `</select>
    </div>`;

    element.innerHTML = html;


}

$(".custom-file-input").on("change", function() {
    var fileName = $(this).val().split("\\").pop();
    $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
  });

// Subir archivo explorador de archivos: https://www.w3schools.com/php/php_file_upload.asp

/*<localfile>
    <log_format>apache</log_format>
    <location>/var/log/apache2/access.log</location>
  </localfile>*/



/* Propiedades Local File
< location > ficheros
< log_format > todos los de arriba
< command > comando  
< alias >: alias que quiera ponerle
< frequency >: en segundos
< check_diff >:
< only-future-events >: Yes/No










*/

