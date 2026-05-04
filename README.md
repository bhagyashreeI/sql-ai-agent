# 🚀 Laravel SQL AI Agent

An intelligent **AI-powered SQL assistant** built using Laravel + React + Laravel AI SDK.  
This project converts natural language into SQL queries with built-in **risk detection, optimization, and Eloquent conversion**.

---

## ✨ Key Features

- 🧠 Natural Language → SQL  
- 🔄 SQL → Laravel Eloquent  
- 🛡️ Dangerous Query Detection (AI Guardrails)  
- 🔧 Auto Query Optimization  
- 📊 Structured JSON Output  
- ⚡ Dual Mode Support (Multi-Agent & Single-Agent)  
- 🎯 Clean React + Inertia UI  

---

## 🏗️ Architecture

```text
User Prompt
   ↓
AI Processing
   ↓
SQL Generation
   ↓
Risk Detection
   ↓
Optimization (if needed)
   ↓
Eloquent Conversion
   ↓
Final Response

## AI Agents


### 🔀 Dual Mode Support

This project supports two approaches:

🧩 1. Multi-Agent Mode

📌 Controller Method:

generate()
Flow:
Prompt → SQL → Risk → Optimize → Eloquent
✅ Pros:
Clean architecture
Separation of concerns
Easy to extend
⚠️ Cons:
Multiple API calls
Can hit rate limits faster

⚡ 2. Single-Agent Mode (Recommended)

📌 Controller Method:

generate_using_singleAgent()
Flow:
Prompt → Smart AI Agent → Final Output
✅ Pros:
Fast response
Single API call
Cost efficient
Avoids rate limits

##  🔄 How to Switch

Update your API routes:

Route::post('/generate', [AiQueryController::class, 'generate']);
Route::post('/generate-optimized', [AiQueryController::class, 'generate_using_singleAgent']);


##  📦 Example Responses
✅ Safe Query
{
  "sql": "SELECT id, name FROM users LIMIT 10",
  "eloquent": "User::select('id','name')->limit(10)->get();",
  "risk": "safe"
}
⚠️ Warning (Auto-Fixed)
{
  "auto_fix": true,
  "sql": "SELECT id, total FROM orders LIMIT 100",
  "eloquent": "Order::select('id','total')->limit(100)->get();",
  "notes": "Optimized query with LIMIT"
}
❌ Dangerous Query
{
  "blocked": true,
  "message": "Dangerous query detected",
  "reason": "DELETE without WHERE"
}

## 🧪 Sample Prompts
Show all orders
Show top 5 customers by revenue
Find users registered last month
Delete all users
⚠️ Rate Limit Handling

## If AI provider is busy:

System retries once
If still failing → returns friendly message
{
  "error": true,
  "message": "AI is currently busy due to high usage. Please try again in 1–2 minutes."
}
## 💻 Tech Stack
Laravel
React
Inertia.js
Laravel AI SDK
Tailwind CSS
MySQL

## ⚡ Installation
git clone <repo>
cd sql-ai-agent

composer install
npm install

cp .env.example .env
php artisan key:generate

php artisan serve
npm run dev

🎯 Why This Project Stands Out
AI + Backend Engineering
Real-world Query Optimization
Security-first approach
Clean architecture design
Production-ready concepts

## 🚀 Future Improvements
Multi-provider AI support (Gemini / OpenAI)
Query performance scoring
Query execution preview
Dashboard analytics
Streaming responses

## 🧠 Recommendation
Mode	                    Use Case
Multi-Agent	Architecture    demo
Single-Agent	            Production & portfolio

## 👉 Use Single-Agent Mode for best performance.

## 🙌 Author

Built to demonstrate modern AI-powered backend engineering with Laravel.