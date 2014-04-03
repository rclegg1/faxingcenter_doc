Faxing Center Api
========


##Authentication OAuth 2.0 ## 

**Endpoint**
```
https://api.faxingcenter.com/oauth
``` 
A Bearer token will be returned which will be required when making requests
```json
{
    "access_token": "3dab7fff9c41f905faa0fdaaa733488acfac4dcf93a6",
    "expires_in": 3600,
    "token_type": "Bearer",
    "scope": null
}
```


###Example Rest Post for Sending Document###

HTTP POST: api.localhost/oauth

HEADERS
  Accept: application/json
  Content-type: application/json
  Authorization: Bearer 3dab7fff9c41f905faa0fdaaa733488acfac4dcf93a6
  
Request Json
```json
{
 "receipients":[
       {
        "reference":"demoraa",
        "send_to":"018555808797"
        }
      ],
 "reference":"demo",
 "documents":[
       {
         "file_name":"testing.txt",
         "file_data":"VGhpcyBpcyBqdXN0IGEgdGVz......",         
         "order":"0"
       }
     ]
}
```

Response Json

```json
{
  "request_reference":"3452e932897d4890aac9a79d53b3805f",
  "result":
   {
    "receipient_count":1,
    "document_count":1,
    "result":
     [{
      "reference":"0cabc8366cdc471ea94dd7284e4b4e5a",
      "send_to":"018555808797",
      "status":"1"
     }]
   },
  "request_status":"1",
  "_links":{"self":{"href":"http:\/\/api.localhost\/api\/rest\/fax\/send"}}
}
```


###Status Response Codes###
- 1 Processing 
- 2 Delivered
- 3 Failed

##Error Handeling##
###Supported HTTP Error Codes###
- 400 Bad Request
- 401 Unauthorized
- 402 Payment Required
- 403 Forbidden
- 404 Not Found
- 405 Method Not Allowed
- 406 Not Acceptable
- 407 Proxy Authentication Required
- 408 Request Time-out
- 409 Conflict
- 410 Gone
- 411 Length Required
- 412 Precondition Failed
- 413 Request Entity Too Large
- 414 Request-URI Too Large
- 415 Unsupported Media Type
- 416 Requested range not satisfiable
- 417 Expectation Failed
- 422 Unprocessable Entity
- 423 Locked
- 424 Failed Dependency
- 425 Unordered Collection
- 426 Upgrade Required
- 428 Precondition Required
- 429 Too Many Requests
- 431 Request Header Fields Too Large

**SERVER ERROR**
-  500 Internal Server Error
-  501 Not Implemented
-  502 Bad Gateway
-  503 Service Unavailable
-  504 Gateway Time-out
-  505 HTTP Version not supported
-  506 Variant Also Negotiates
-  507 Insufficient Storage
-  508 Loop Detected
-  511 Network Authentication Required

##Example Error Response##
**Http Response Headers**
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
 "detail":
 "Phone number is invalid"
}
```

**application/problem+json Error Codes**

- 100 Invalid Phone Number
- 110 Document Data is missing 
