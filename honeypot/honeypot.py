import socket

honeypot_port = 12345  # Replace with your chosen port number

def start_honeypot():
    with socket.socket(socket.AF_INET, socket.SOCK_STREAM) as server_socket:
        server_socket.bind(('0.0.0.0', honeypot_port))
        server_socket.listen()

        print(f"Honeypot listening on port {honeypot_port}")

        while True:
            client_socket, addr = server_socket.accept()
            print(f"Connection from: {addr}")

            # Simulate a basic login form
            client_socket.send(b"Welcome to the login page. Please enter your credentials.\n")
            username = client_socket.recv(1024).strip().decode()
            password = client_socket.recv(1024).strip().decode()

            # Log the connection and login attempt
            with open('honeypot.log', 'a') as log_file:
                log_file.write(f"Connection from {addr}, Username: {username}, Password: {password}\n")

            client_socket.send(b"Login failed. Please try again.\n")
            client_socket.close()

if __name__ == "__main__":
    start_honeypot()
