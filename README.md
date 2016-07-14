# MIT-WebSIS-Data-Extractor

A PHP and cURL based data extraction module for our online SIS portal @ MIT.

---

- [x] Course Details
- [x] Attendance
- [x] Internal Assessments (1, 2 & 3)
- [x] GCG
  - [x] Grades
  - [x] Total Credits per Sem
  - [x] GPA Acquired per Sem
- [ ] Do something useful with jSON responses 

---
Documentation
------

####Valid Links (http://websis.herokuapp.com/ ... ):
- semester/\<requested\_sem\>/\<requested\_data\>
  - \<requested\_sem\> → ( 1 to 8 ) | 'latest' 
  - \<requested\_data\> → 'attendace' | 'course' | 'marks/IA1' | 'marks/IA2' | 'marks/IA3' | gcg

####Valid HTTP Headers:
- username* → Student ID [ XXXXXXXXX ]
- password* → Student Date of Birth [ YYYY-MM-DD ]
- testcode → test | postgresTest | testAfterLogin | varDump
  - test: Executes test code before anything else
  - postgresTest: Used to test Database connection, returns all IDs present in DB as test result
  - testAfterLogin: Executes test code after login into webSIS
  - varDump: Dumps all variables after data retrival from webSIS
- shouldupdate → ( on | ON )
  - Bypasses webSIS, returns jSON from the Data Base

\* → Required

####Status Responses:
- 200 Ok: jSON retrived and displayed
- 204 No Content: jSON returned NULL

####Data Base Structure:
roll\_no | data\_of\_birth | attendance | course | marks\_ia1 | marks\_ia2 | marks\_ia3 | gcg
------------ | ------------- | ------------- | ------------- | ------------- | ------------- | ------------- | -------------
varchar(9) | varchar(10) | jSON | jSON | jSON | jSON | jSON | jSON 

####Data Base jSON Format:
```jSON
{
  "Semester 4": {
    "<requested_data>": [
      
    ],
    "lastUpdated": "time_stamp",
  },
  "Semester 3": {
    "<requested_data>": [
     
    ],
    "lastUpdated": "time_stamp",
  },
  "Semester 2": {
    "<requested_data>": [
      
    ],
    "lastUpdated": "time_stamp",
  },
  "Semester 1": {
    "<requested_data>": [
      
    ],
    "lastUpdated": "time_stamp"
  }
}
```

####Timing(s) Observed:
- Normal Response: 11000ms to 17000ms
- Data Base Response (w/ shouldupdate = NO): 2000ms to 4000ms
