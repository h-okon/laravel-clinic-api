
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

##Register a new doctor

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



