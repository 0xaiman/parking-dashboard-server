import random
import time
from datetime import datetime, timedelta

import requests

# API endpoint
API_URL = "http://127.0.0.1:8000/api/parking-events"

# Simulation time range
START_TIME = datetime.strptime("2025-03-23 10:00:00", "%Y-%m-%d %H:%M:%S")
END_TIME = datetime.strptime("2025-03-23 22:00:00", "%Y-%m-%d %H:%M:%S")

# Sample vehicles (20 unique cars)
VEHICLES = [
    {"license_plate": "ABC123", "plate_color": "Black", "vehicle_color": "Gray", "vehicle_brand": "Toyota"},
    {"license_plate": "XYZ789", "plate_color": "White", "vehicle_color": "Blue", "vehicle_brand": "Honda"},
    {"license_plate": "LMN456", "plate_color": "Red", "vehicle_color": "Red", "vehicle_brand": "Ford"},
    {"license_plate": "JKL987", "plate_color": "Blue", "vehicle_color": "Black", "vehicle_brand": "BMW"},
    {"license_plate": "GHI321", "plate_color": "Black", "vehicle_color": "White", "vehicle_brand": "Nissan"},
    {"license_plate": "PQR654", "plate_color": "Gray", "vehicle_color": "Gray", "vehicle_brand": "Mazda"},
    {"license_plate": "DEF111", "plate_color": "Silver", "vehicle_color": "Silver", "vehicle_brand": "Tesla"},
    {"license_plate": "UVW222", "plate_color": "Yellow", "vehicle_color": "Yellow", "vehicle_brand": "Mercedes"},
    {"license_plate": "STU333", "plate_color": "Green", "vehicle_color": "Green", "vehicle_brand": "Subaru"},
    {"license_plate": "QAZ444", "plate_color": "Brown", "vehicle_color": "Brown", "vehicle_brand": "Hyundai"},
    {"license_plate": "WSX555", "plate_color": "White", "vehicle_color": "White", "vehicle_brand": "Audi"},
    {"license_plate": "EDC666", "plate_color": "Blue", "vehicle_color": "Blue", "vehicle_brand": "Volkswagen"},
    {"license_plate": "RFV777", "plate_color": "Black", "vehicle_color": "Black", "vehicle_brand": "Chevrolet"},
    {"license_plate": "TGB888", "plate_color": "Gray", "vehicle_color": "Gray", "vehicle_brand": "Kia"},
    {"license_plate": "YHN999", "plate_color": "Red", "vehicle_color": "Red", "vehicle_brand": "Lexus"},
    {"license_plate": "UJM000", "plate_color": "Silver", "vehicle_color": "Silver", "vehicle_brand": "Infiniti"},
    {"license_plate": "IKJ111", "plate_color": "White", "vehicle_color": "White", "vehicle_brand": "Acura"},
    {"license_plate": "OLP222", "plate_color": "Black", "vehicle_color": "Black", "vehicle_brand": "Jaguar"},
    {"license_plate": "ZXM333", "plate_color": "Blue", "vehicle_color": "Blue", "vehicle_brand": "Porsche"},
    {"license_plate": "CVB444", "plate_color": "Gray", "vehicle_color": "Gray", "vehicle_brand": "Mitsubishi"}
]

# Active parking spaces to track occupied ones
active_parking = {}

# Simulate parking events
current_time = START_TIME
while current_time < END_TIME:
    # Pick a random parking space
    space_id = random.randint(1, 60)

    # Ensure the space is free before parking a new car
    if space_id not in active_parking:
        # Assign a random device (assumed 10 devices)
        device_id = random.randint(1, 10)

        # Pick a random vehicle
        vehicle = random.choice(VEHICLES)

        # Set occupancy duration (1 to 3 hours)
        duration = random.randint(1, 3)

        # Send parking event (car enters)
        payload = {
            "device_id": device_id,
            "space_id": space_id,
            "event_time": current_time.strftime("%Y-%m-%d %H:%M:%S"),
            "report_type": "trigger",
            "occupancy": 1,
            "license_plate": vehicle["license_plate"],
            "plate_color": vehicle["plate_color"],
            "vehicle_type": "Car",
            "vehicle_color": vehicle["vehicle_color"],
            "vehicle_brand": vehicle["vehicle_brand"]
        }

        response = requests.post(API_URL, json=payload)
        print(f"[{current_time.strftime('%H:%M')}] Car Parked -> Space {space_id} | {vehicle['license_plate']} | Status: {response.status_code}")

        # Mark parking space as occupied
        active_parking[space_id] = current_time + timedelta(hours=duration)

    # Check for departures
    for space, leave_time in list(active_parking.items()):
        if current_time >= leave_time:
            # Send departure event (car leaves)
            payload = {
                "device_id": random.randint(1, 10),
                "space_id": space,
                "event_time": current_time.strftime("%Y-%m-%d %H:%M:%S"),
                "report_type": "trigger",
                "occupancy": 0
            }
            response = requests.post(API_URL, json=payload)
            print(f"[{current_time.strftime('%H:%M')}] Car Left -> Space {space} | Status: {response.status_code}")

            # Free the parking space
            del active_parking[space]

    # Move time forward by a random interval (5 to 15 minutes)
    current_time += timedelta(minutes=random.randint(5, 15))

    # Wait a bit to avoid flooding the API
    time.sleep(0.5)
