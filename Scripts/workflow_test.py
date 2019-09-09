#!/usr/bin/env python
import requests
import os
import subprocess
import sys

final_dict = {}

argvLen = len(sys.argv)

if argvLen > 1:
        inputFileName = sys.argv[1]
        workDirectory = sys.argv[2]
        #check whether file exist into the location if not then give error message else proceed further
        if os.path.exists(inputFileName):
                try:
                        #extract base name from file name without extension
                        inputFileBaseName = os.path.splitext(os.path.basename(inputFileName))[0]

                        stageOutputFile = workDirectory + "variantDetails_"+inputFileBaseName+".txt"

                        finalOutputFile = workDirectory + "HV1HV2_" + inputFileBaseName + ".txt"

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
                print("Total",totalLines,"variants are present in input sample from HVS1 and HVS2 region")
                #message = "Total "+str(totalLines)+" variants are present in test sample from HVS1 and HVS2 region"
                #print("totalLines type")
                #print(type(totalLines))

                ##====== to compare 2 files and count the matches found
                # comparing Indian global variants file (638 global) with Hv1 Hv2 regions of input file
                p = subprocess.getoutput("awk -F'\t' 'NR==FNR{c[$2$3$4$5]++;next};c[$2$3$4$5] > 0' "+workDirectory+"Indian_global_638.txt " + finalOutputFile + " | wc -l")
                f = open(workDirectory+"matchedVars_IndianGlobal.txt", "w")
                s = subprocess.getoutput("awk -F'\t' 'NR==FNR{c[$2$3$4$5]++;next};c[$2$3$4$5] > 0' "+workDirectory+"Indian_global_638.txt " + finalOutputFile )
                f.write(s)
                f.close()
                u = subprocess.getoutput("awk -F'\t' '{b=$4$2$5 \"\t\" $11 \"\t\" $12; print b}' "+workDirectory+"matchedVars_IndianGlobal.txt")
                f = open(workDirectory+"vars_InidanGlobal.txt", "w")
                f.write(u)
                f.close()
                matches = int(p)
                #message += "<br>"+ str(matches)+" variants from input sample match with the Indian variants"
                print(matches,"variants from input sample match with the global Indian variants")
                #final_dict["output_file"] = workDirectory+"vars.txt"
                #print("matches type")
                #print(type(matches))

                percentage = round((matches/totalLines)*100,2)
                print("Conclusion: The input sample variants are ", percentage,"% match with the global Indian variants")
                #message += "<br> Conclusion: The probability of input sample variants being Indian is "+ str(percentage)+"%"
                #final_dict["message"] = message
                #print(final_dict)
                #print(type(percentage))
                
                ###=================== 
                # comparing unique Indian variants file (308 unique) with Hv1 Hv2 regions of input file 
                
                p1 = subprocess.getoutput("awk -F'\t' 'NR==FNR{c[$2$3$4$5]++;next};c[$2$3$4$5] > 0' "+workDirectory+"allIndianvars_final_308.txt " + finalOutputFile + " | wc -l")
                f = open(workDirectory+"matchedVars_IndianUnique.txt", "w")
                s1 = subprocess.getoutput("awk -F'\t' 'NR==FNR{c[$2$3$4$5]++;next};c[$2$3$4$5] > 0' "+workDirectory+"allIndianvars_final_308.txt " + finalOutputFile )
                f.write(s1)
                f.close()
                u1 = subprocess.getoutput("awk -F'\t' '{b=$4$2$5 \"\t\" $11 \"\t\" $12; print b}' "+workDirectory+"matchedVars_IndianUnique.txt")
                f = open(workDirectory+"vars_IndianUnique.txt", "w")
                f.write(u1)
                f.close()
                matches1 = int(p1)
                #message += "<br>"+ str(matches)+" variants from input sample match with the Indian variants"
                print(matches1,"variants from input sample match with the unique Indian variants")
                #final_dict["output_file"] = workDirectory+"vars.txt"
                #print("matches type")
                #print(type(matches))

                percentage1 = round((matches1/totalLines)*100,2)
                print("Conclusion: The input sample variants are ",percentage1,"% unique to India")
                #message += "<br> Conclusion: The probability of input sample variants being Indian is "+ str(percentage)+"%"
                #final_dict["message"] = message
                #print(final_dict)
                #print(type(percentage))
                # to generate vars.txt for php code (this coombines 2 text files files into 1)
                p2 = subprocess.getoutput("cut -b 1- "+workDirectory+"vars_InidanGlobal.txt "+workDirectory+"vars_IndianUnique.txt > "+workDirectory+"vars.txt")
        else:
                print("Input file doesn't exist")
else:
        print("No arguments found.")
