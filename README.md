# Laravel Ollama

![Laravel](https://img.shields.io/badge/Laravel-13.x-red)
![PHP](https://img.shields.io/badge/PHP-8.3%2B-blue)
![Ollama](https://img.shields.io/badge/Ollama-Local%20AI-black)
![Docker](https://img.shields.io/badge/Docker-Ready-blue)
![License](https://img.shields.io/badge/License-MIT-green)
![Status](https://img.shields.io/badge/Status-Stable-success)

A **Laravel API project that integrates with Ollama (local LLM)** to demonstrate practical usage of:

- Generate API
- Chat API
- Tool Calling (function execution via AI)

The project focuses on connecting Laravel with AI models running locally through Ollama and executing real PHP functions based on model decisions.

---

## 📌 What is this?

**Laravel Ollama** is a backend API that connects Laravel with Ollama and allows the model to execute server-side PHP functions through Tool Calling.

The system provides three main AI capabilities:

- Generate text from a prompt
- Chat with context
- Execute tools (functions) dynamically

The project includes a practical example of external data retrieval using a **CNPJ API lookup**.

---

## 🎯 What is it for?

This project is intended to:

- Demonstrate Laravel + Ollama integration
- Test Ollama API capabilities locally
- Understand Tool Calling workflows
- Execute PHP functions from AI decisions
- Build a foundation for AI-powered backend systems

It is ideal for developers who want to learn:

- AI integration with Laravel
- Tool Calling architecture
- Local LLM usage with Ollama
- Backend automation using AI

---

## 🧠 How does it work?

Users send a prompt to Laravel, which communicates with Ollama.

Depending on the request, the model can:

- Respond normally (Generate / Chat)
- Decide to call a tool (Tool Calling)
- Execute a PHP function (example: CNPJ lookup)
- Return structured data to the model
- Generate a final AI response

### Flow:

User Prompt  
↓  
Laravel Controller  
↓  
Ollama API  
↓  
Tool Detection (if needed)  
↓  
PHP Function Execution  
↓  
External API Request (CNPJ)  
↓  
Response returned to Ollama  
↓  
Final response to user

---

## 🚀 Quick Installation

### 1️⃣ Clone the repository

```bash
git clone https://github.com/ezequiel-tzofeheer/Laravel-Ollama.git
````
2️⃣ Access the project directory

```bash
cd Laravel-Ollama
```

3️⃣ Create the environment file

```bash
cp .env.example .env
```

4️⃣ Build and start the containers

```bash
sudo docker compose up -d
```

5️⃣ Access the Docker container

```bash
sudo docker compose exec app bash
```

6️⃣ Install Laravel dependencies

```bash
composer install
```

7️⃣ Generate the application key

```bash
php artisan key:generate
```

8️⃣ Run the database migrations

```bash
php artisan migrate
```

## 🌐 Access

- Application: http://localhost:8096
- PhpMyAdmin: http://localhost:8550

---

## 🌐 API Endpoints

### Generate

```http
POST /generate
```

### Chat

```http
POST /chat
```

### Tool Calling

```http
POST /tool-calling
```

## 🧩 Tech Stack

- PHP 8.3+
- Laravel 13
- Ollama (local LLM)
- Docker
- Laravel HTTP Client
- Public CNPJ API

---

## 🏗️ Architecture

```text
Laravel API
↓
Ollama (LLM)
↓
Tool Calling Engine
↓
PHP Function Execution
↓
External API (CNPJ)
↓
Final AI Response
```

## 🎯 Core Features

- Generate endpoint (stateless AI response)
- Chat endpoint (context-aware responses)
- Tool Calling system
- PHP function execution via AI
- External API integration
- JSON structured communication

---

## 📖 Postman Documentation

https://www.postman.com/tzheer/laravel-ollama/overview

---

## 🤝 Contributing

Contributions are welcome.

You can contribute by:

- Opening issues
- Submitting pull requests
- Suggesting improvements
- Improving documentation

---

## 🙌 Credits

- Laravel Framework
- Ollama
- CNPJ Public API
- Open Source Community

---

## ⭐ Support

If this project helped you, consider leaving a ⭐ on GitHub.

---

## 👤 Author

Developed and maintained by **Ezequiel Tzofeheer**

Full Stack Developer focused on:

- Backend Systems
- AI Integration
- Laravel Ecosystem
- API Design
- Clean Architecture

---

## 📄 License

This project is licensed under the MIT License.
