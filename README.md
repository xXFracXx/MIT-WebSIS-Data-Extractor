# MIT-WebSIS-Data-Extractor

A PHP and cURL based data extraction module for our online SIS portal @ MIT.

---

- [x] Course Details
- [x] Attendance
- [x] Internal Assessments (1, 2 & 3)
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
- username* → Student ID [ 14XXXXXXX ]
- password* → Student Date of Birth [ YYYY-MM-DD ]
- testcode → test | postgresTest | testAfterLogin | varDump
  - test: Executes test code before anything else
  - postgresTest: Used to test Database connection, returns all IDs present in DB as test result
  - testAfterLogin: Executes test code after login into webSIS
  - varDump: Dumps all variables after data retrival from webSIS

\* → Required

####Data Format:
```jSON
{
  "Semester 4": {
    "attendance": [
      
    ],
    "lastUpdated": "2016/07/13 11:59:27 am",
  },
  "Semester 3": {
    "attendance": [
     
    ],
    "lastUpdated": "2016/07/13 10:20:50 am"
  },
  "Semester 2": {
    "attendance": [
      
    ],
    "lastUpdated": "2016/07/13 10:21:08 am"
  },
  "Semester 1": {
    "attendance": [
      
    ],
    "lastUpdated": "2016/07/13 10:21:23 am"
  }
}
```
