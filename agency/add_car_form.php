<form action="add_car.php" method="POST" enctype="multipart/form-data">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="vehicle_model">Vehicle Model</label>
                <input type="text" name="vehicle_model" id="vehicle_model" class="form-control" required>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="body_type">Body Type</label>
                <select name="body_type" id="body_type" class="form-control" required>
                    <option value="">Select Body Type</option>
                    <option value="Sedan">Sedan</option>
                    <option value="SUV">SUV</option>
                    <option value="Hatchback">Hatchback</option>
                </select>
            </div>
        </div>
    </div>
    <!-- Second row -->
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="fuel">Fuel Type</label>
                <select name="fuel" id="fuel" class="form-control" required>
                    <option value="">Select Fuel Type</option>
                    <option value="Petrol">Petrol</option>
                    <option value="Diesel">Diesel</option>
                    <option value="Electric">Electric</option>
                    <option value="Cng">CNG</option>
                </select>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="transmission">Transmission</label>
                <select name="transmission" id="transmission" class="form-control" required>
                    <option value="">Select Transmission Type</option>
                    <option value="Manual">Manual</option>
                    <option value="Automatic">Automatic</option>
                </select>
            </div>
        </div>
    </div>
    <!-- Third row -->
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="vehicle_number">Vehicle Number</label>
                <input type="text" name="vehicle_number" id="vehicle_number" class="form-control" required>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="seating_capacity">Seating Capacity</label>
                <select name="seating_capacity" id="seating_capacity" class="form-control" required>
                    <option value="">Select Seating Capacity</option>
                    <option value="2">2</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="7">7</option>
                </select>
            </div>
        </div>
    </div>
    <!-- Fourth row -->
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="rent_per_day">Rent Per Day (INR)</label>
                <input type="number" name="rent_per_day" id="rent_per_day" class="form-control" required>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="image">Car Image</label>
                <input type="file" name="image" id="image" class="form-control-file" accept="image/*">
            </div>
        </div>
    </div>
    <button type="submit" class="btn btn-primary">Add Car</button>
</form>