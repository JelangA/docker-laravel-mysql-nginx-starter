# API Documentation for PMW

This document provides details about the API endpoints available for the PMW project.

## Base URL

All API requests use the following base URL:
```
http://localhost:8000
```

---

## Routes Overview

- [Auth](#auth)
    - [Register](#11-register)
    - [Login](#12-login)
- [Student](#student)
    - [Get Students](#21-get-students)
    - [Search Students](#22-search-students)
    - [Get Student by ID](#23-get-student-by-id)

---

## Authentication

This API uses **API Key** authentication. Include the API key in the `X-API-Key` header for all requests requiring authentication.

### Example Header:
```http
X-API-Key: {{token}}
```

---

## Endpoints

### **1. Auth**

#### **1.1 Register**

- **URL:** `POST /api/auth/register`
- **Description:** Registers a new user.

##### Request Body:
```json
{
  "nim": "231524044",
  "name": "jelang",
  "major": "Computer Science",
  "study_program": "D4",
  "year": "2023",
  "email": "jelang@gmail.com",
  "status": "active",
  "password": "jelang123"
}
```

##### Response:
**Success (200):**
```json
{
  "metadata": {
    "code": 200,
    "status": "success",
    "message": "Register success"
  },
  "data": null
}
```
**Failure (400):**
```json
{
  "metadata": {
    "code": 400,
    "status": "failed",
    "message": "SQLSTATE[23000]: Integrity constraint violation: ..."
  },
  "data": null
}
```

---

#### **1.2 Login**

- **URL:** `POST /api/auth/login`
- **Description:** Authenticates a user and returns an access token.

##### Request Body:
```json
{
  "email": "jelang@gmail.com",
  "password": "jelang123"
}
```

##### Response:
**Success (200):**
```json
{
  "metadata": {
    "code": 200,
    "status": "success",
    "message": "1|x4ITYDodVq2mPPvOOA38ZBuhKL0kTCDKKaU2f9Fl1ac7e8fd"
  },
  "data": null
}
```
**Failure (401):**
```json
{
  "metadata": {
    "code": 401,
    "status": "failed",
    "message": "Invalid password"
  },
  "data": null
}
```

---

### **2. Student**

#### **2.1 Get Students**

- **URL:** `GET /api/students`
- **Description:** Retrieves a list of all students.

##### Response:
**Success (200):**
```json
{
  "data": [
    {
      "nim": "231524045",
      "name": "bangkong",
      "major": "Computer Science",
      "study_program": "D4",
      "year": "2023",
      "email": "kong@gmail.com",
      "status": "active",
      "created_at": "2024-12-23T07:05:24.000000Z",
      "updated_at": "2024-12-23T07:05:24.000000Z"
    }
  ]
}
```

---

#### **2.2 Search Students**

- **URL:** `GET /api/students/search`
- **Description:** Searches students based on NIM.
- **Query Parameters:**
    - `nim`: Partial or complete NIM (max length: 9).

##### Example:
```
GET /api/students/search?nim=23152
```

##### Response:
**Success (200):**
```json
{
  "data": [
    {
      "nim": "231524001",
      "name": "ALNEZ RAINANSANTANA",
      "major": "Teknik Komputer dan Informatika",
      "study_program": "D4-Teknik Informatika",
      "year": "2023",
      "email": "alnez.rainansantana.tif423@polban.ac.id",
      "status": "Mahasiswa Aktif",
      "created_at": null,
      "updated_at": null
    }
  ]
}
```
**Failure (404):**
```json
{
  "message": "No students found for the provided query."
}
```
**Failure (422):**
```json
{
  "message": "The nim field must not be greater than 9 characters."
}
```

---

#### **2.3 Get Student by ID**

- **URL:** `GET /api/students/{nim}`
- **Description:** Retrieves details of a specific student by NIM.

##### Response:
**Success (200):**
```json
{
  "data": {
    "nim": "231524046",
    "name": "John",
    "major": "Computer Science",
    "study_program": "D4",
    "year": "2023",
    "email": "johnlang@gmail.com",
    "status": "active",
    "created_at": "2024-11-23T01:46:52.000000Z",
    "updated_at": "2024-11-23T01:46:52.000000Z"
  }
}
```
**Failure (404):**
```json
{
  "message": "No query results for model [App\\Models\\Student] 2315240464"
}
```

---

## Error Codes

- **200:** Success.
- **400:** Bad Request.
- **401:** Unauthorized.
- **404:** Not Found.
- **422:** Unprocessable Content.
