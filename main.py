import uvicorn
from fastapi import FastAPI
from fastapi.exceptions import RequestValidationError
from starlette.middleware.cors import CORSMiddleware
from starlette.responses import PlainTextResponse

from core import config
from core import urls
from core.middlewares.settings import settings_middleware
from core.utils.log import configure_rotating_logger

app = FastAPI(title=config.PROJECT_NAME, openapi_url="/api/v1/openapi.json")

# CORS
origins = []

# Set all CORS enabled origins

if config.BACKEND_CORS_ORIGINS:
    origins_raw = config.BACKEND_CORS_ORIGINS.split(",")
    for origin in origins_raw:
        use_origin = origin.strip()
        origins.append(use_origin)
    app.add_middleware(
        CORSMiddleware,
        allow_origins=origins,
        allow_credentials=True,
        allow_methods=["*"],
        allow_headers=["*"],
    )


app.include_router(urls.router)

app.middleware('http')(settings_middleware(app))

@app.on_event("startup")
def startup_event():
    configure_rotating_logger('ifglife', debug=True)


@app.exception_handler(RequestValidationError)
async def validation_exception_handler(request, exc):
    return PlainTextResponse(str(exc), status_code=400)


if __name__ == "__main__":
    uvicorn.run(app=app)