<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>MCP Finance System API Docs</title>
    <link rel="stylesheet" href="https://unpkg.com/swagger-ui-dist@5/swagger-ui.css" />
</head>
<body>
    <h1>ww</h1>
<div id="swagger-ui"></div>

<script src="https://unpkg.com/swagger-ui-dist@5/swagger-ui-bundle.js"></script>
<script>
    window.onload = () => {
        SwaggerUIBundle({
            url: "{{ url('docs/openapi.yaml') }}", // <-- tu OpenAPI dentro del proyecto
            dom_id: '#swagger-ui',
        });
    };
</script>
</body>
</html>
