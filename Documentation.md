
# API Documentation - laravel-clinic-api

# Authorization:

# Log-in
Used to collect a Token for a registered User.

**URL** : `/api/login/`

**Method** : `POST`

**Auth required** : NO

**Data constraints**

```json
{
    "email": "[valid email address]",
    "password": "[password in plain text]"
}
```

**Data example**

```json
{
    "email": "test@yandex.ru",
    "password": "coolpassword123"
}
```

## Success Response

**Code** : `200 OK`

**Content example**

```json
{
    "success": {
        "token": "verycooltoken"
    }
}
```

## Error Response

**Condition** : If 'username' and 'password' combination is wrong.

**Code** : `401 UNAUTHORIZED`

**Content** :

```json
{
    "error": "Unauthorized."
}
```
**Condition** : If 'username' or 'password' is missing.

**Code** : `401 UNAUTHORIZED`

**Content** :

```json
{
    "error": {
        "password": [
            "The password field is required."
        ]
    }
}
```
```json
{
    "error": {
        "email": [
            "The email field is required."
        ]
    }
}
```
# Register

Used to register a new user.

**URL** : `/api/register/`

**Method** : `POST`

**Auth required** : NO

**Data constraints**

```json
{
    "email": "[valid email address]",
    "name": "[name]",
    "password": "[password in plain text]",
    "c_password": "[password in plain text]",
    "pesel": "[number, min: 8, unique]",
}
```

**Data example**

```json

{
    "email": "test@yandex.ru",
    "name": "Jan Kowalski",
    "password": "coolpassword123",
    "c_password": "coolpassword123",
    "pesel": "123456789",
}
```

## Success Response

**Code** : `200 OK`

**Content example**

```json
{
    "success": {
        "token": "verycooltoken",
        "name": "Jan Kowalski"
    }
}
```

## Error Response

**Condition** : If one of the field is missing (example for c_password)

**Code** : `401 UNAUTHORIZED`

**Content** :

```json
{
    "error": {
        "c_password": [
            "The c password field is required."
        ]
    }
}
```

**Condition** : If password and c_password are not the same:

**Code** : `401 UNAUTHORIZED`

**Content** :

```json
{
    "error": {
        "c_password": [
            "The c password and password must match."
        ]
    }
}
```

**Condition** : If email is already taken

**Code** : `401 UNAUTHORIZED`

**Content** :

```json
{
    "error": {
        "email": [
            "The email has already been taken."
        ]
    }
}
```

## Register a new doctor

Used to register a new user.

**URL** : `/api/register_doctor`

**Method** : `POST`

**Auth required** : NO

**Data constraints**

```json
{
    "email": "[valid email address]",
    "name": "[name]",
    "password": "[password in plain text]",
    "c_password": "[password in plain text]",
    "pesel": "[number, min: 8, unique]",
    "specialization": "[string, name of specialization]"
}
```


# Prescription


# Add a new prescription

Used to register a new user.

**URL** : `/api/prescription/`

**Method** : `POST`

**Auth required** : auth:api, doctor

**Data constraints**

```json
{
    "patient_id": "[int: user_id of the patient]",
    "doctor_id": "[int: user_id of the doctor]",
    "content": "[plain text content]"
}
```

**Data example**

```json

{
    "patient_id": 5,
    "doctor_id": 39,
    "content": "Rotarix 1,5ml 2x daily"
}
```

## Success Response

**Code** : `200 OK`

**Content example**

```json
{
    "success": {
        "patient_id": "5",
        "doctor_id": "39",
        "content": "Rotarix 1,5ml 2x daily",
        "updated_at": "2020-12-07T20:55:15.000000Z",
        "created_at": "2020-12-07T20:55:15.000000Z",
        "id": 4042
    }
}
```

## Error Response

**Condition** : If one of the field is missing (example for c_password)

**Code** : `401 UNAUTHORIZED`

**Content** :

```json
{
    "error": {
        "content": [
            "The content field is required."
        ]
    }
}
```
# List prescriptions for given Patient

Returns a list of prescriptions for a user

**URL** : `/api/prescription/{id}`

**Method** : `GET`

**Auth required** : auth:api

**Data constraints**

```json
{
    {id} : id of the user you would like to get the prescriptions
}
```

**Data example**

: `/api/prescription/5`

## Success Response

**Code** : `200 OK`

**Content example**

```json
{
    "success": 
    {
        "id": 1,
        "created_at": "2020-12-07T20:49:36.000000Z",
        "updated_at": "2020-12-07T20:49:36.000000Z",
        "patient_id": "1",
        "doctor_id": "1",
        "access_code": "9936",
        "content": "samplecontent"
    },
    {
        "id": 2,
        "created_at": "2020-12-07T20:54:17.000000Z",
        "updated_at": "2020-12-07T20:54:17.000000Z",
        "patient_id": "1",
        "doctor_id": "1",
        "access_code": "9936",
        "content": "Second Sample Content"
    }
}
```

## Error Response

**Condition** : The user does not exsist

**Code** : `400 BAD REQUEST`

**Content** :

```json
{
    "error": {
        "No query result for model User with id 71."
    }
}
```


