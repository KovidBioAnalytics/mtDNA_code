#!/usr/bin/env python
import requests
import os
import subprocess
import sys

argvLen = len(sys.argv)

if argvLen > 1:
        inputFileName = sys.argv[1]
        inputFilePath = sys.argv[2]
        #check whether file exist into the location if not then give error message else proceed further
        if os.path.exists(inputFileName):
                try:
                        #extract base name from file name without extension
                        inputFileBaseName = os.path.splitext(os.path.basename(inputFileName))[0]

                        stageOutputFile = inputFilePath+"variantDetails_"+inputFileBaseName+".txt"

                        finalOutputFile = inputFilePath+"HV1HV2_" + inputFileBaseName + ".txt"

                        f = open(stageOutputFile, "w")
                        
                        response = requests.post("https://mitomap.org/mitomaster/websrvc.cgi", files={"file": open(inputFileName), 'fileType': ('', 'sequences'), 'output': ('', 'detail')})
                        f.write(str(response.content, 'utf-8'))
                        f.close()
                except requests.exceptions.HTTPError as err:
                        print("HTTP error: " + err)
                except:
                        print("Error")

                # to extract HVS1 and HVS2 regions from the file

                hv1hv2_extraction = "awk '{if ($8 ~ /CR:HVS1/ || /CR:HVS2/ ) print $0}' "+stageOutputFile+" > "+finalOutputFile
                os.system(hv1hv2_extraction)


                ##=====count the total number of lines in test sample file
                q = subprocess.getoutput("tail " + finalOutputFile + " | wc -l")
                totalLines = int(q)
                print("Total",totalLines,"variants are present in test sample from HVS1 and HVS2 region")
                #print("totalLines type")
                #print(type(totalLines))

                ##====== to compare 2 files and count the matches found
                p = subprocess.getoutput("awk -F'\t' 'NR==FNR{c[$2$3$4$5]++;next};c[$2$3$4$5] > 0' allvariants_duplicatesRemoved.txt " + finalOutputFile + " | wc -l")
                matches = int(p)
                print(matches,"variants from test sample match with the Indian variants")
                #print("matches type")
                #print(type(matches))

                percentage = (matches/totalLines)*100
                print("Conclusion: Test sample is", percentage, "% Indian")
                #print(type(percentage))
        else:
                print("Input file doesn't exist")
else:
        print("No arguments found.")
