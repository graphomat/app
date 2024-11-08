from http.server import HTTPServer, SimpleHTTPRequestHandler
import os

class Handler(SimpleHTTPRequestHandler):
    def __init__(self, *args, **kwargs):
        super().__init__(*args, directory=os.path.dirname(os.path.abspath(__file__)), **kwargs)

if __name__ == "__main__":
    server_address = ('', 8007)  # Changed port to 8007
    httpd = HTTPServer(server_address, Handler)
    print("Server running on http://localhost:8007")
    httpd.serve_forever()
