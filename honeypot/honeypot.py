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

            response_headers = [
                'HTTP/1.0 200 OK',
                'Content-Type: text/html',
            ]

            html_content = [
                '<html lang="en">',
                '  <head>',
                '    <meta charset="UTF-8">',
                '    <title>Honeypot Server Control</title>',
                '    <style>body { font-family: monospace; }</style>',
                '  </head>',
                '  <body>',
                '    <h2>Welcome to the access panel admin.</h2>',
                '    <h3>Please login:</h3>',
                '    <form method="POST" action="/login">',
                '      <label for="uname"><b>Username</b></label>',
                '      <input type="text" placeholder="Enter Username" name="uname" required>',
                '      <label for="psw"><b>Password</b></label>',
                '      <input type="password" placeholder="Enter Password" name="psw" required>',
                '      <button type="submit">Login</button>',
                '    </form>',
                '  </body>',
                '</html>'
            ]

            response_headers = '\r\n'.join(response_headers)
            html_content = '\r\n'.join(html_content)

            response = response_headers + '\r\n\r\n' + html_content
            client_socket.send(response.encode())

            # Log the connection
            with open('honeypot.log', 'a') as log_file:
                log_file.write(f"Connection from {addr}\n")

            #client_socket.close()

if __name__ == "__main__":
    start_honeypot()
