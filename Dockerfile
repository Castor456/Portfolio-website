# Use lightweight Nginx image
FROM nginx:alpine

# Set working directory inside the container
WORKDIR /usr/share/nginx/html

# Remove default Nginx page
RUN rm -rf ./*

# Copy all your portfolio website files into the container
COPY . .

# Expose port 80 (Nginx default)
EXPOSE 80

# Nginx runs automatically, so no CMD needed
