# Stage 1: Build
FROM node:22-alpine AS build
WORKDIR /app

# Copy dependency files and install
COPY frontend/package.json frontend/package-lock.json ./
RUN npm install

# Copy the rest of the frontend project
COPY frontend/ ./

# Build only in production mode
ARG NODE_ENV=production
RUN if [ "$NODE_ENV" = "production" ]; then npm run build; fi

# Stage 2: Runtime
FROM node:22-alpine
WORKDIR /app

# Copy build output (only needed in production)
COPY --from=build /app/.output/ ./

# Copy source for dev mode
COPY --from=build /app/ ./

# Expose port (3000 for dev, 80 for prod)
ENV PORT=3000
ENV HOST=0.0.0.0
EXPOSE 3000

# Start command switches based on NODE_ENV
CMD if [ "$NODE_ENV" = "production" ]; then \
      npm run start; \
    else \
      npx nuxt dev --host 0.0.0.0 --port 3000; \
    fi
