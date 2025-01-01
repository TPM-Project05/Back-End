# Register

**Description:**

**Request:**
- **Method:** POST  
- **URL:** http://127.0.0.1:8000/register  
- **Headers:** None  
- **Body:**
```json
{
  "email": "string",
  "password": "string"
}
```

**Validation:**
- **email:**
  - Required:
    - Must be a valid email format.
    - Must be unique.
- **password:**
  - Required:
    - Minimum 8 characters.
    - At least one uppercase letter.
    - At least one lowercase letter.
    - At least one number.
    - At least one special character (e.g., @, #, !).

**Responses:**
- **201 - Created:**
```json
{
  "id": "integer",
  "email": "string"
}
```
- **400 - Bad Request:**
```json
{
  "message": "Email is required"
}
```
OR
```json
{
  "message": "Invalid email format"
}
```
OR
```json
{
  "message": "Email must be unique"
}
```
OR
```json
{
  "message": "Password is required"
}
```
OR
```json
{
  "message": "Password must be at least 8 characters and include uppercase, lowercase, number, and special character"
}
```

---

# Login

**Description:**


**Request:**
- **Method:** POST  
- **URL:** http://127.0.0.1:8000/login  
- **Headers:** None  
- **Body:**
```json
{
  "email": "string",
  "password": "string"
}
```

**Validation:**
- **email:**
  - Required:
    - Must be a valid email format.
- **password:**
  - Required:

**Responses:**
- **200 - OK:**
```json
{
  "access_token": "string"
}
```
- **400 - Bad Request:**
```json
{
  "message": "Email is required"
}
```
OR
```json
{
  "message": "Password is required"
}
```
- **401 - Unauthorized:**
```json
{
  "message": "Invalid email/password"
}
```

---

# Leader Info

**Description:**


**Request:**
- **Method:** POST  
- **URL:** http://127.0.0.1:8000/leader-form  
- **Headers:**
```json
{
  "Authorization": "Bearer <access_token>"
}
```
- **Body:**
```json
{
  "fullName": "string",
  "email": "string",
  "whatsappNumber": "string",
  "lineId": "string",
  "githubGitlabId": "string",
  "birthPlace": "string",
  "birthDate": "YYYY-MM-DD",
  "cvFile": "file"
}
```

**Validation:**
- **fullName:**
  - Required:
- **email:**
  - Required:
    - Must be a valid email format.
- **whatsappNumber:**
  - Required:
    - Must be a valid phone number format.
- **lineId:**
  - Required:
- **githubGitlabId:**
  - Required:
- **birthPlace:**
  - Required:
- **birthDate:**
  - Required:
    - Must be in YYYY-MM-DD format.
- **cvFile:**
  - Required:
    - Must be a valid file upload.

**Responses:**
- **201 - Created:**
```json
{
  "message": "Leader information submitted successfully"
}
```
- **400 - Bad Request:**
```json
{
  "message": "Full Name is required"
}
```
OR
```json
{
  "message": "Invalid email format"
}
```
OR
```json
{
  "message": "WhatsApp Number is required"
}
```
OR
```json
{
  "message": "Birth Place is required"
}
```
OR
```json
{
  "message": "Invalid birth date format"
}
```
OR
```json
{
  "message": "CV file is required"
}
```

