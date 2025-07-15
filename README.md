## How to Run

1. Copy **.env.example** to **.evn**
2. Check Port Availability**
   Ensure that ports **8000** and **33306** are available on your machine.
   If they are already in use, you can modify the `docker-compose.yaml` file to use different ports.

   > ⚠️ This project intentionally does **not** use environment variables for port configuration.

3. Run Setup Script
   To simplify the setup, you can use the provided shell script:

   ```bash
   ./setup.sh
   ```

FE url: http://localhost:8000/static/index.html
Admin url: http://localhost:8000/visits
