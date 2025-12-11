# Laravel MCP Finance System  
Sistema financiero demo diseñado para integrar **Laravel 12**, **Sanctum**, y **Model Context Protocol (MCP)** para agentes de IA.

---

## 🚀 Objetivo del proyecto

Este proyecto sirve como base para empresas que desean:

- Integrar sus sistemas internos (ERP, CRM, Core Financiero, etc.) con **agentes de IA**.
- Exponer información sensible mediante un modelo seguro basado en **API REST + MCP**.
- Realizar pruebas rápidas de conexión, flujos LLM, herramientas MCP y automatizaciones.

El proyecto está dividido en **dos capas**:

---

## 🧱 Estructura del sistema

### 1️⃣ Backend de datos — *Laravel API + Sanctum*
Responsable de:

- Autenticación de usuarios vía tokens Sanctum.
- Exponer endpoints REST seguros.
- Consultar información simulada: usuarios, cuentas, resúmenes financieros.
- Gestionar la seguridad para accesos externos.

### 2️⃣ Capa MCP — *Server MCP*
Responsable de:

- Ser consumido por agentes externos: OpenAI ChatGPT, Postman MCP, VSCode MCP, etc.
- Publicar tools como:
  - `get-user-financial-summary`
  - (otros tools financieros agregables)
- Controlar el acceso mediante tokens Sanctum.

---

## 🔐 Seguridad

Este proyecto implementa:

- **Sanctum** con tokens personales.
- Protección total de rutas mediante `auth:sanctum`.
- Un endpoint `GET /api/login` que devuelve JSON amigable cuando falta autenticación.
- CORS configurado para acceso controlado.
- MCP protegido para evitar conexiones no autenticadas.

---

## 📦 Instalación

### 1️⃣ Clonar proyecto

```bash
git clone https://github.com/mi-org/laravel-mcp-finance.git
cd laravel-mcp-finance
