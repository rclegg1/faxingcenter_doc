Faxing Center Production Fax Api
========

Before you can access the api you must contact the [FaxingCenter](https://www.faxingcenter.com/production_fax) and have been issued a client id and client secret token. 


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

###Get the status of a specific fax job / send id (sid)

---

###Get the status of a specific receipient / message id (mid)

---

###Search for fax jobs a Fax

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
