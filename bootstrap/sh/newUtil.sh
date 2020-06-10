#!/bin/sh
# Simple utilities
# Add a new file
# Add a new remote host to be monitored via lynx
# Add a new remote host to be monitored (DNS)
# Add a new command to be monitored
# by Daniel B. Cid - dcid ( at ) ossec.net

# NAME=${NAME//%/ }

ACTION=$1
DOMAIN=$2


if ! [ -e /etc/ossec-init.conf ]; then
    echo OSSEC Manager not found. Exiting...
    exit 1
fi

. /etc/ossec-init.conf


if [ "X$DOMAIN" = "X" ]; then
    echo "$0: addcommand <format>"
    echo "$0: addfile type <format>"
    echo "$0: adddns  <format>"
    echo "$0: addsite  <format>"

    echo ""

    echo "Info: $0 addcommand <filename.sh> <name_command> <expect> <time_allowed>"
    echo "Info: $0 addfile command <format_command> <command> <alias_custom> <frequency>"
    echo "Info: $0 addfile file <log_format> <path/filename.log> <check_diff> <only_read_future>"
    echo "Info: $0 addresponse <disable> <command> <location> <level> <timeout>"
    echo "Info: $0 adddns dns"
    echo "Info: $0 addsite site"

    echo ""

    echo "Example: $0 addcommand disable-account.sh disable-account user yes"
    echo "Example: $0 addfile command full-command df_-P_arg alias_custom 20 "
    echo "Example: $0 addfile file syslog /var/log/pre.log yes yes"
    echo "Example: $0 adddns 0.0.0.0"
    echo "Example: $0 addsite www.osec.net"
    exit 1;
fi


if [ $ACTION = "addcommand" ]; then

#variable if add command
	FILE=$3
	NAME=$2
	EXPECT=$4
	TIME=$5

	DISABLE=$6
	LOCATION=$7
	RULES_ID=$8
	LEVEL=$9

    # Checking if file is already configured
    grep "$FILE" /var/ossec/etc/ossec.conf > /dev/null 2>&1
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


   if [ "X$DISABLE" = "X" ]; then
        echo "
        <ossec_config>
        <command>
            <name>$NAME</name>
            <executable>$FILE</executable>
            <expect>$EXPECT</expect>
            <timeout_allowed>$TIME</timeout_allowed>
        </command>
 	</ossec_config>
        " >> /var/ossec/etc/ossec.conf
    else
        echo "
            <ossec_config>
                <command>
                    <name>$NAME</name>
                    <executable>$FILE</executable>
                    <expect>$EXPECT</expect>
                    <timeout_allowed>$TIME</timeout_allowed>
                </command>
           
        <active-response>
            <disabled>$DISABLE</disabled>
            <command>$NAME</command>
            <location>$LOCATION</location>
            <level>$LEVEL</level>
            <rules_id>$RULES_ID</rules_id>
        </active-response>
        </ossec_config>
        ">> /var/ossec/etc/ossec.conf
    fi

   echo "$0: File $FILE added.";
   exit 0;            
fi

# Adding a new file

if [ $ACTION = "addfile" ]; then
    # Checking if file is already configured
	
	#variable if add file
	TYPEE=$2
	LOGFORMAT=$3
	FILECOMMAND=$4
	ARG5=$5
	ARG6=$6


	
     if [ $TYPEE = "file" ]; then
        grep "$FILECOMMAND" /var/ossec/etc/ossec.conf > /dev/null 2>&1
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
        " >> /var/ossec/etc/ossec.conf  
        echo "$0: File $FILECOMMAND added.";
        exit 0;  
     fi

     if [ $TYPEE = "command" ]; then
         echo "
            <ossec_config>
                <localfile>
                    <log_format>$LOGFORMAT</log_format>
                    <command >$FILECOMMAND</command >
                    <alias>$ARG5</alias>
                    <frequency>$ARG6</frequency>
                </localfile>
            </ossec_config>  
        " >> /var/ossec/etc/ossec.conf  
        echo "$0: Command $FILECOMMAND added.";
        exit 0;  
     fi
             
fi

## Adding a new DNS check
if [ $ACTION = "adddns" ]; then
   COMMAND="host -W 5 -t NS $DOMAIN; host -W 5 -t A $DOMAIN | sort"
   echo $DOMAIN | grep -E '^[a-z0-9A-Z.-]+$' >/dev/null 2>&1
   if [ $? = 1 ]; then
      echo "$0: Invalid domain: $DOMAIN"
      exit 1;
   fi

   grep "host -W 5 -t NS $DOMAIN" /var/ossec/etc/ossec.conf >/dev/null 2>&1
   if [ $? = 0 ]; then
       echo "$0: Already configured for $DOMAIN"
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
   " >> /var/ossec/etc/ossec.conf || MYERR=1;

   if [ $MYERR = 1 ]; then
       echo "$0: Unable to modify the configuration file."; 
       exit 1;
   fi

   FIRSTRULE="150010"
   while [ 1 ]; do
       grep "\"$FIRSTRULE\"" /var/ossec/rules/local_rules.xml > /dev/null 2>&1
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
     <match>^ossec: output: 'host -W 5 -t NS $DOMAIN</match>
     <description>DNS Changed for $DOMAIN</description>
   </rule>
   </group>
   " >> /var/ossec/rules/local_rules.xml || MYERR=1;

   if [ $MYERR = 1 ]; then
       echo "$0: Unable to modify the local rules file.";
       exit 1;
   fi

   echo "Domain $DOMAIN added to be monitored."
   exit 0;
fi


# Adding a new lynx check
if [ $ACTION = "addsite" ]; then
   COMMAND="lynx --connect_timeout 10 --dump $DOMAIN | head -n 10"
   echo $DOMAIN | grep -E '^[a-z0-9A-Z.-]+$' >/dev/null 2>&1
   if [ $? = 1 ]; then
      echo "$0: Invalid domain: $DOMAIN"
      exit 1;
   fi

   grep "lynx --connect_timeout 10 --dump $DOMAIN" /var/ossec/etc/ossec.conf >/dev/null 2>&1
   if [ $? = 0 ]; then
       echo "$0: Already configured for $DOMAIN"
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
   " >> /var/ossec/etc/ossec.conf || MYERR=1;

   if [ $MYERR = 1 ]; then
       echo "$0: Unable to modify the configuration file."; 
       exit 1;
   fi

   FIRSTRULE="150010"
   while [ 1 ]; do
       grep "\"$FIRSTRULE\"" /var/ossec/rules/local_rules.xml > /dev/null 2>&1
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
     <match>^ossec: output: 'lynx --connect_timeout 10 --dump $DOMAIN</match>
     <description>DNS Changed for $DOMAIN</description>
   </rule>
   </group>
   " >> /var/ossec/rules/local_rules.xml || MYERR=1;

   if [ $MYERR = 1 ]; then
       echo "$0: Unable to modify the local rules file.";
       exit 1;
   fi

   echo "Domain $DOMAIN added to be monitored."
   exit 0;
fi
