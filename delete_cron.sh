#!/bin/bash
(crontab -l | grep -v "/1 * * * 1-5 /usr/bin/curl --silent --compressed https://www.fineoutput.co.in/automation/Apicontroller/case5/Index/afterorderdb") | crontab -