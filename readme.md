FORMAT: 1A

# COMPANY-SERVICE

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
                        "_id": "string",
                        "name": "string",
                        "code": "string"
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
                    "_id": "string",
                    "name": "string",
                    "code": "string"
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
                "id": null
            }

+ Response 200 (application/json)
    + Body

            {
                "status": "success",
                "data": {
                    "_id": "string",
                    "name": "string",
                    "code": "string"
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