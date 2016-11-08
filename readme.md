FORMAT: 1A

# Company

# Company [/companies]
Company  resource representation.

## Show all companies [GET /companies]


+ Request (application/json)
    + Body

            {
                "search": {
                    "_id": "string",
                    "name": "string",
                    "code": "string"
                },
                "sort": {
                    "newest": "asc|desc"
                },
                "take": "integer",
                "skip": "integer"
            }

+ Response 200 (application/json)
    + Body

            {
                "status": "success",
                "data": {
                    "data": {
                        "_id": {
                            "value": "1234567890",
                            "type": "string",
                            "max": "255"
                        },
                        "name": {
                            "value": "PT THUNDERLABS INDONESIA",
                            "type": "string",
                            "max": "255"
                        },
                        "code": {
                            "value": "TLID",
                            "type": "string",
                            "max": "255"
                        }
                    },
                    "count": "integer"
                }
            }

## Store Company [POST /companies]


+ Request (application/json)
    + Body

            {
                "_id": "string",
                "name": "string",
                "code": "string"
            }

+ Response 200 (application/json)
    + Body

            {
                "status": "success",
                "data": {
                    "_id": {
                        "value": "1234567890",
                        "type": "string",
                        "max": "255"
                    },
                    "name": {
                        "value": "PT THUNDERLABS INDONESIA",
                        "type": "string",
                        "max": "255"
                    },
                    "code": {
                        "value": "TLID",
                        "type": "string",
                        "max": "255"
                    }
                }
            }

+ Response 200 (application/json)
    + Body

            {
                "status": {
                    "error": [
                        "code must be unique."
                    ]
                }
            }

## Delete Company [DELETE /companies]


+ Request (application/json)
    + Body

            {
                "_id": null
            }

+ Response 200 (application/json)
    + Body

            {
                "status": "success",
                "data": {
                    "_id": {
                        "value": "1234567890",
                        "type": "string",
                        "max": "255"
                    },
                    "name": {
                        "value": "PT THUNDERLABS INDONESIA",
                        "type": "string",
                        "max": "255"
                    },
                    "code": {
                        "value": "TLID",
                        "type": "string",
                        "max": "255"
                    }
                }
            }

+ Response 200 (application/json)
    + Body

            {
                "status": {
                    "error": [
                        "code must be unique."
                    ]
                }
            }