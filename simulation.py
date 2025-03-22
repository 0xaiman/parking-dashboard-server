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
    {"license_plate": "ABC123", "plate_color": "Black", "vehicle_color": "Gray", "vehicle_brand": "Toyota", "owner": "John Doe", "membership_status": "member"},
    {"license_plate": "XYZ789", "plate_color": "White", "vehicle_color": "Blue", "vehicle_brand": "Honda", "owner": "Jane Smith", "membership_status": "guest"},
    {"license_plate": "LMN456", "plate_color": "Red", "vehicle_color": "Red", "vehicle_brand": "Perodua", "owner": "Alice Johnson", "membership_status": "member"},
    {"license_plate": "JKL987", "plate_color": "Blue", "vehicle_color": "Black", "vehicle_brand": "Proton", "owner": "Robert Brown", "membership_status": "staff"},
    {"license_plate": "GHI321", "plate_color": "Black", "vehicle_color": "White", "vehicle_brand": "Nissan", "owner": "Emily Davis", "membership_status": "guest"},
    {"license_plate": "PQR654", "plate_color": "Gray", "vehicle_color": "Gray", "vehicle_brand": "Mazda", "owner": "Michael Wilson", "membership_status": "member"},
    {"license_plate": "DEF111", "plate_color": "Silver", "vehicle_color": "Silver", "vehicle_brand": "Toyota", "owner": "Sophia Martinez", "membership_status": "staff"},
    {"license_plate": "UVW222", "plate_color": "Yellow", "vehicle_color": "Yellow", "vehicle_brand": "Perodua", "owner": "James Anderson", "membership_status": "member"},
    {"license_plate": "STU333", "plate_color": "Green", "vehicle_color": "Green", "vehicle_brand": "Proton", "owner": "Olivia Taylor", "membership_status": "guest"},
    {"license_plate": "QAZ444", "plate_color": "Brown", "vehicle_color": "Brown", "vehicle_brand": "Produa", "owner": "Liam Thomas", "membership_status": "member"},
    {"license_plate": "WSX555", "plate_color": "White", "vehicle_color": "White", "vehicle_brand": "Proton", "owner": "Ava White", "membership_status": "staff"},
    {"license_plate": "EDC666", "plate_color": "Blue", "vehicle_color": "Blue", "vehicle_brand": "Perodua", "owner": "Noah Harris", "membership_status": "guest"},
    {"license_plate": "RFV777", "plate_color": "Black", "vehicle_color": "Black", "vehicle_brand": "Perodua", "owner": "Mia Clark", "membership_status": "member"},
    {"license_plate": "TGB888", "plate_color": "Gray", "vehicle_color": "Gray", "vehicle_brand": "Proton", "owner": "William Hall", "membership_status": "guest"},
    {"license_plate": "YHN999", "plate_color": "Red", "vehicle_color": "Red", "vehicle_brand": "Proton", "owner": "Emma Allen", "membership_status": "staff"},
    {"license_plate": "UJM000", "plate_color": "Silver", "vehicle_color": "Silver", "vehicle_brand": "Proton", "owner": "Lucas Young", "membership_status": "member"},
    {"license_plate": "IKJ111", "plate_color": "White", "vehicle_color": "White", "vehicle_brand": "Proton", "owner": "Charlotte King", "membership_status": "guest"},
    {"license_plate": "OLP222", "plate_color": "Black", "vehicle_color": "Black", "vehicle_brand": "Proton", "owner": "Benjamin Scott", "membership_status": "staff"},
    {"license_plate": "ZXM333", "plate_color": "Blue", "vehicle_color": "Blue", "vehicle_brand": "Porsche", "owner": "Harper Green", "membership_status": "member"},
    {"license_plate": "CVB444", "plate_color": "Gray", "vehicle_color": "Gray", "vehicle_brand": "Perodua", "owner": "Ethan Adams", "membership_status": "guest"},
        {"license_plate": "IKJ111", "plate_color": "White", "vehicle_color": "White", "vehicle_brand": "Proton", "owner": "Charlotte King", "membership_status": "guest"},
    {"license_plate": "OLP222", "plate_color": "Black", "vehicle_color": "Black", "vehicle_brand": "Proton", "owner": "Benjamin Scott", "membership_status": "staff"},
    {"license_plate": "ZXM333", "plate_color": "Blue", "vehicle_color": "Blue", "vehicle_brand": "Porsche", "owner": "Harper Green", "membership_status": "member"},
    {"license_plate": "CVB444", "plate_color": "Gray", "vehicle_color": "Gray", "vehicle_brand": "Perodua", "owner": "Ethan Adams", "membership_status": "guest"},
    
    {"license_plate": "WXY555", "plate_color": "White", "vehicle_color": "White", "vehicle_brand": "Perodua", "owner": "Aiman Malik", "membership_status": "member"},
    {"license_plate": "LMN666", "plate_color": "Silver", "vehicle_color": "Silver", "vehicle_brand": "Proton", "owner": "Farhan Rosli", "membership_status": "guest"},
    {"license_plate": "BVC777", "plate_color": "Black", "vehicle_color": "Black", "vehicle_brand": "Toyota", "owner": "Nur Aisyah", "membership_status": "member"},
    {"license_plate": "HGF888", "plate_color": "Red", "vehicle_color": "Red", "vehicle_brand": "Honda", "owner": "Muhammad Hafiz", "membership_status": "staff"},
    {"license_plate": "POI999", "plate_color": "Blue", "vehicle_color": "Blue", "vehicle_brand": "Proton", "owner": "Syafiq Rahman", "membership_status": "guest"},
    {"license_plate": "TRE101", "plate_color": "Gray", "vehicle_color": "Gray", "vehicle_brand": "Mazda", "owner": "Siti Norfaezah", "membership_status": "guest"},
    
    {"license_plate": "XYZ202", "plate_color": "Black", "vehicle_color": "Black", "vehicle_brand": "Perodua", "owner": "Ahmad Fadhil", "membership_status": "member"},
    {"license_plate": "ABC303", "plate_color": "White", "vehicle_color": "White", "vehicle_brand": "Proton", "owner": "Nur Ain", "membership_status": "staff"},
    {"license_plate": "JKL404", "plate_color": "Gray", "vehicle_color": "Gray", "vehicle_brand": "Toyota", "owner": "Hanafi Bakar", "membership_status": "guest"},
    {"license_plate": "QWE505", "plate_color": "Silver", "vehicle_color": "Silver", "vehicle_brand": "Nissan", "owner": "Adli Azlan", "membership_status": "member"},
    {"license_plate": "RTY606", "plate_color": "Blue", "vehicle_color": "Blue", "vehicle_brand": "Honda", "owner": "Zaid Abdul", "membership_status": "guest"},
    {"license_plate": "UOP707", "plate_color": "Black", "vehicle_color": "Black", "vehicle_brand": "Perodua", "owner": "Nor Shafiq", "membership_status": "staff"},
    
    {"license_plate": "VBN808", "plate_color": "White", "vehicle_color": "White", "vehicle_brand": "Mazda", "owner": "Siti Ameerah", "membership_status": "guest"},
    {"license_plate": "ZXC909", "plate_color": "Gray", "vehicle_color": "Gray", "vehicle_brand": "Proton", "owner": "Faris Dani", "membership_status": "member"},
    {"license_plate": "MNB111", "plate_color": "Silver", "vehicle_color": "Silver", "vehicle_brand": "Toyota", "owner": "Aida Sofea", "membership_status": "staff"},
    {"license_plate": "LKJ222", "plate_color": "Black", "vehicle_color": "Black", "vehicle_brand": "Nissan", "owner": "Izwan Hakim", "membership_status": "guest"}
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
            "vehicle_brand": vehicle["vehicle_brand"],
            "owner": vehicle["owner"],
            "membership_status": vehicle["membership_status"]
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
