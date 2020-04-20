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

#variable if add command
FILE=$2
NAME=$3
EXPECT=$4
TIME=$5

#variable if add file
TYPE=$2
LOGFORMAT=$3
FILECOMMAND=$4
ARG5=$5
ARG6=$6

#variable if add response
DISABLE=$2
COMMAND=$3
LOCATION=$4
LEVEL=$5
TIMEOUT=$6


if ! [ -e /etc/ossec-init.conf ]; then
    echo OSSEC Manager not found. Exiting...
    exit 1
fi

. /etc/ossec-init.conf


if [ "X$FILE" = "X" ]; then
    echo "$0: addcommand <format>"
    echo "$0: addfile type <format>"
    echo "$0: addresponse  <format>"

    echo ""

    echo "Info: $0 addcommand <filename.sh> <name_command> <expect> <time_allowed>"
    echo "Info: $0 addfile command <format_command> <command> <alias_custom> <frequency>"
    echo "Info: $0 addfile file <log_format> <path/filename.log> <check_diff> <only_read_future>"
    echo "Info: $0 addresponse <disable> <command> <location> <level> <timeout>"

    echo ""

    echo "Example: $0 addcommand disable-account.sh disable-account user yes"
    echo "Example: $0 addfile command full-command df_-P alias_custom 20 "
    echo "Example: $0 addfile file syslog /var/log/pre.log yes yes"
    echo "Example: $0 addresponse no firewall-drop local 6 600"
    exit 1;
fi


#Adding a new command

if [ "X$NAME" = "X" ]; then
     echo "need a name"
     exit 1;
fi

if [ "X$EXPECT" = "X" ]; then
    EXPECT="user"
fi

if [ "X$TIME" = "X" ]; then
    TIME="no"
fi


if [ $ACTION = "addcommand" ]; then
    # Checking if file is already configured
    grep "$FILE" ${DIRECTORY}/etc/ossec.conf > /dev/null 2>&1
    if [ $? = 0 ]; then
        echo "$0: Command $FILE already configured at ossec."
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
        <command>
            <name>$NAME</name>
            <executable>$FILE</executable>
            <expect>$EXPECT</expect>
            <timeout_allowed>$TIME</timeout_allowed>
        </command>
    </ossec_config>
   " >> ${DIRECTORY}/etc/ossec.conf

   echo "$0: File $FILE added.";
   exit 0;            
fi


# Adding a new file
TYPE=$2
LOGFORMAT=$3
FILECOMMAND=$4 #path of file or name of command
ARG5=$5 #check_diff or alias depend of type
ARG6=$6 #only-future-events or frequency depend of type


if [ "X$TYPE" = "X" ]; then
     echo "need a type"
     exit 1;
fi

if [ "X$LOGFORMAT" = "X" ]; then
     echo "need a log format"
     exit 1;
fi

if [ "X$FILECOMMAND" = "X" ]; then
     echo "need a location or command"
     exit 1;
fi



if [ $ACTION = "addfile" ]; then
    # Checking if file is already configured



     if [ $TYPE = "file" ]; then
        grep "$FILECOMMAND" ${DIRECTORY}/etc/ossec.conf > /dev/null 2>&1
        if [ $? = 0 ]; then
            echo "$0: File $FILECOMMAND already configured at ossec."
            exit 1;
        fi

        # Checking if file exist
        ls -la $FILECOMMAND > /dev/null 2>&1
        if [ ! $? = 0 ]; then
            echo "$0: File $FILECOMMAND does not exist."
            exit 1;
        fi

         echo "
         <ossec_config>
            <localfile>
                <log_format>$LOGFORMAT</log_format>
                <location>$FILECOMMAND</location>
                <check_diff>$ARG5</check_diff >
                <only-future-events>$ARG6</only-future-events>
            </localfile>
        </ossec_config>  
        " >> ${DIRECTORY}/etc/ossec.conf  
        echo "$0: File $FILE added.";
        exit 0;  
     fi

     if [ $TYPE = "command" ]; then
         echo "
            <ossec_config>
                <localfile>
                    <log_format>$LOGFORMAT</log_format>
                    <command >$FILECOMMAND</command >
                    <alias>$ARG5</alias>
                    <frequency>$ARG6</frequency>
                </localfile>
            </ossec_config>  
        " >> ${DIRECTORY}/etc/ossec.conf  
        echo "$0: Command $FILE added.";
        exit 0;  
     fi
             
fi

## Adding a new DNS check
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
