Faxing Center Production Fax Api
========

Before you can access the api you must contact the [FaxingCenter](https://www.faxingcenter.com/contact-us) and have been issued a client id and client secret token. 


##Authentication using OAuth 2.0

**HTTP Method:** `post`

**Endpoint:** `https://api.faxingcenter.com/oauth`

**HTTP Headers:**
```
  Accept: application/json
  Content-type: application/json
``` 


**Request**

```json
{
  "client_id" : "Your Client Id",
  "client_secret" : "Your Client Secret",
  "grant_type" : "client_credentials"
}
```


**Response**

A Bearer token will be returned which will be required when making requests. A new access token will be generated each time you send an authenticate request.

```json
{
    "access_token": "3dab7fff9c41f905faa0fdaaa733488acfac4dcf93a6",
    "expires_in": 3600,
    "token_type": "Bearer"
}
```

---

###Sending a Fax

**HTTP method:** `post`

**Http Endpoint:** `https://api.faxingcenter.com/api/rest/fax/send`

**Http Headers:**
```
  Accept: application/json
  Content-type: application/json
  Authorization: Bearer 3dab7fff9c41f905faa0fdaaa733488acfac4dcf93a6
```


**Request**

```json
{
  "receipients":[
    {"fax_number":"13862345678"}
   ],
  "documents":[
    {
     "file_name":"myfile.pdf",
     "file_data":"bas64 encode string content of myfile.pdf","order":0
    }
   ]
}
```


**Response**

```json
{
  "sid":"d4b7b6b6914b45fa974e155b9a0af837",
  "result":{
    "total_documents":1,
    "receipients":[
      {
        "mid":"ddea632371464331876ed5182b9678c6",
        "fax_number":"13862345678",
        "status":"1"
      }
    ]
  }
}
```

---

###Get the status of a specific fax job 


**HTTP Method:** `GET`

**Endpoint:** `https://api.faxingcenter.com/api/rest/fax/status`

**HTTP Headers:**
```
  Accept: application/json
  Content-type: application/json
``` 
The method supports two parameters

| Parameter | Required | Description |
|:---:|:---:|:---|
| sid | Yes | Send Id. Required for each request and will return all receipient messages for that send id |
| mid | No | Message Id. Will return the specific receipient message |

**Example**

`https://api.faxingcenter.com/api/rest/fax/status?sid=d4b7b6b6914b45fa974e155b9a0af837`

**Result**

```json
{"results":[
	{"sid":"4bb8dd16063f43f6927e8923bd08b30a", // Send Id
     "mid":"e03be073902c4e7e998ce3a4b84cf694", // Message Id
     "fax_number":"18555808797",               
     "status":"1",
     "sent_on":"2014-04-08T17:26:25-04:00", 
     "attempts": "",
     "pages": ""
     "received_on": ""   
   }],
  "pager":{
	  "pageCount":1,
	  "itemCountPerPage":100,
	  "first":1,
	  "current":1,
	  "last":1,
	  "currentItemCount":1,
	  "totalItemCount":1,
	  "firstItemNumber":1,
	  "lastItemNumber":1
}}
```

---

###Search for fax jobs 


**HTTP Method:** `GET`

**Endpoint:** `https://api.faxingcenter.com/api/rest/fax/search`

**HTTP Headers:**
```
  Accept: application/json
  Content-type: application/json
``` 
The method supports two parameters

| Parameter | Required | Description |
|:---:|:---:|:---|
| from_date | Yes | eg: 2014-01-30T00:00:00-5:00 |
| to_date | Yes | eg: 2014-01-30T23:59:59-5:00 |
| fax_number | No | Filter by fax number |
| status | No | Filter by status |

**Example**

`http://api.faxingcenter.com/api/rest/fax/search?from_date=04%2F01%2F2014&to_date=04%2F30%2F2014&fax_number=18555808797&status=1`

**Result**

```json
{"results":[
	{"sid":"4bb8dd16063f43f6927e8923bd08b30a", // Send Id
     "mid":"e03be073902c4e7e998ce3a4b84cf694", // Message Id
     "fax_number":"18555808797",               
     "status":"1",
     "sent_on":"2014-04-08T17:26:25-04:00",
     "attempts": "",
     "pages": ""
     "received_on": ""
   }],
  "pager":{
	  "pageCount":1,
	  "itemCountPerPage":100,
	  "first":1,
	  "current":1,
	  "last":1,
	  "currentItemCount":1,
	  "totalItemCount":1,
	  "firstItemNumber":1,
	  "lastItemNumber":1
}}
```

---

###Fax message status codes###

| Code        | Status
| ------------- |:-------------:
| 1             | Processing 
| 2             | Delivered      
| 3             | Failed 

---

###Error Handeling###

**Example Response Headers**
```
HTTP/1.1 406 Not Acceptable
Content-type: application/problem+json
```

```json
{
 "code":100,
 "culprit":"failing value or identifier",
 "type":"http://www.w3.org/Protocols/rfc2616/rfc2616-sec10.html",
 "title":"Not Acceptable",
 "status":406,
 "detail": "Phone number is invalid"
}
```

**Error Codes**

| Code      | Error Message            |
|-----------|--------------------------|
|   100     | Invalid Phone Number     |
|   110     | Document Data is missing |
