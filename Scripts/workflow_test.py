#!/usr/bin/env python
import requests
import os
import subprocess
import sys

final_dict = {}

argvLen = len(sys.argv)
if argvLen > 1:
	u2 = ""
	case3_out = ""
	inputFileName = sys.argv[1]
	workDirectory = sys.argv[2]
	inputFileBaseName = os.path.splitext(os.path.basename(inputFileName))[0]
	fastaFileName = inputFileBaseName+"_fa1.fasta"
	if inputFileName.endswith('.fastq'):
		inp1 = subprocess.getoutput(" sed '/^@/!d;s//>/;N' "+inputFileName+ ">" +workDirectory+fastaFileName)
		inp2 = subprocess.getoutput(" sed '1!{/^>/ d}' " +workDirectory+fastaFileName+ ">"+workDirectory+inputFileBaseName+"_fa.fasta")
		inp2 = workDirectory+inputFileBaseName+"_fa.fasta"
	elif inputFileName.endswith('.fasta') or inputFileName.endswith('.fa') :inp2 = inputFileName
	#check whether file exist into the location if not then give error message else proceed further
	if os.path.exists(inp2):
		try:
			#extract base name from file name without extension
			inputFileBaseName = os.path.splitext(os.path.basename(inp2))[0]
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
		#print("Total",totalLines,"variants are present in input sample from HVS1 and HVS2 region")
		u2 += "Total variants (of Indian / non-Indian origin) found in HSV1 and HSV2 region of mtDNA: "+str(totalLines)+"\n"
			
		###=================== case3
		# It is possible that all the indian samples are not coovered during exaustive variants extraction for Indian samples. So we might not get 
		# a match for query position from the sample in our unique or global indian list ($2$3$4$5). So this is case 3 in which we will just 
		# match reference position and ref and variant allele from the variant details file (i.e ($2$4$5))
		p2 = subprocess.getoutput("awk -F'\t' 'NR==FNR{c[$2$4$5]++;next};c[$2$4$5] > 0' "+workDirectory+"allvariants_final_948.txt " + finalOutputFile + " | wc -l")
		matches2 = int(p2)
		percentage = 0
		try:
			percentage = round((matches2/totalLines)*100,2)
		except ZeroDivisionError:
			percentage = 0
			
		f = open(workDirectory+"matchedVars_Indian.txt", "w")
		s2 = subprocess.getoutput("awk -F'\t' 'NR==FNR{c[$2$4$5]++;next};c[$2$4$5] > 0' "+workDirectory+"allvariants_final_948.txt " + finalOutputFile )
		f.write(s2)
		f.close()
		case3_out = subprocess.getoutput("awk -F'\t' '{b=$4$2$5 \"\t\" $11 \"\t\" $12 \"\t\" "+str(percentage)+"; print b}' "+workDirectory+"matchedVars_Indian.txt")
		f = open(workDirectory+"vars_Indian.txt", "w")
		f.write(case3_out)
		f.close()
		#message += "<br>"+ str(matches)+" variants from input sample match with the Indian variants"
		#print(matches2," variants from input sample match with the Indian variants")
		u2 += "Variants of Indian origin found in HSV1 and HSV2 region of mtDNA: "+str(matches2)
		#final_dict["output_file"] = workDirectory+"vars.txt"
		#print("matches type")
		#print(type(matches))
		#message += "<br> Conclusion: The probability of input sample variants being Indian is "+ str(percentage)+"%"
		#final_dict["message"] = message
		#print(final_dict)
		#print(type(percentage))
		
	
		##==============================
		# t generate vars.txt for php code (this coombines 2 text files files into 1)
		print(u2)
		f = open(workDirectory+"vars.txt", "w")
		f.write(case3_out)
		f.close()
	else:
		os.remove(workDirectory+"vars.txt")
		print("Input file doesn't exist")
else:
	os.remove(workDirectory+"vars.txt")
	print("No arguments found.")
