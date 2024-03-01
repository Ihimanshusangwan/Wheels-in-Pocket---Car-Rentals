document.addEventListener("DOMContentLoaded", function () {
  const carContainer = document.getElementById("carContainer");
  const moreBtn = document.getElementById("moreBtn");
  const loading = document.getElementById("loading");
  let offset = 0;

  // Function to fetch cars using Fetch API
  function fetchCars() {
    loading.style.display = "block"; // Display loading animation
    fetch(`fetch_cars.php?offset=${offset}`)
      .then((response) => response.json())
      .then((data) => {
        loading.style.display = "none"; // Hide loading animation
        if (data.length > 0) {
          data.forEach((car) => {
            let bookingForm = "";
            if (isCustomerSession) {
                bookingForm = `
                <div class="booking-form">
                    <form action="customer/rent_car.php" method="post"> 
                        <label for="start_date">Start Date</label>
                        <input type="date" id="start_date" name="start_date" class="form-control mb-2" placeholder="Start Date" required>
                        
                        <label for="number_of_days">Number of Days</label>
                        <select id="number_of_days" name="number_of_days" class="form-control mb-2" required>
                            <option value="">Select Number of Days</option>
                            <option value="1">1 Day</option>
                            <option value="2">2 Days</option>
                            <option value="3">3 Days</option>
                            <option value="4">4 Days</option>
                            <option value="5">5 Days</option>
                            <option value="6">6 Days</option>
                            <option value="7">7 Days</option>
                            <option value="8">8 Days</option>
                            <option value="9">9 Days</option>
                            <option value="10">10 Days</option>
                        </select>
            
                        <input type="hidden" name="car_id" value="${car.car_id}">
                        
                        <button type="submit" class="btn btn-primary btn-sm btn-block"><i class="fas fa-car"></i> Rent Car</button> 
                    </form>
                </div>`;
            }
             else {
              bookingForm = `
              <a href="signin.php" class="btn btn-primary btn-sm btn-block"><i class="fas fa-car"></i> Rent Car</a>
              <p>Login as Customer to rent</p>`;
            }

            carContainer.innerHTML += `
                    <div class="col-md-4 mb-3">
                        <div class="card">
                            <div class="card-body">
                                ${
                                  car.images
                                    ? `<img src="${car.images}" class="card-img" alt="${car.vehicle_model}">`
                                    : `<img src="default_car_image.jpg" class="card-img" alt="Default Car Image">`
                                }
                                <h5 class="card-title text-primary text-center">${
                                  car.vehicle_model
                                }</h5>
                                <h6 class="card-title text-secondary">${
                                  car.agency_name
                                }</h6>
                                <div class="row">
                                    <div class="col-md-6">
                                        <p class="card-text mb-0"><i class="fas fa-car text-success"></i> <span class="text-small">${
                                          car.body_type
                                        }</span></p>
                                        <p class="card-text mb-0"><i class="fas fa-gas-pump text-danger"></i> <span class="text-small">${
                                          car.fuel
                                        }</span></p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="card-text mb-0"><i class="fas fa-cogs text-warning"></i> <span class="text-small">${
                                          car.transmission
                                        }</span></p>
                                        <p class="card-text mb-0"><i class="fas fa-chair text-info"></i> <span class="text-small">${
                                          car.seating_capacity
                                        } Seats</span></p>
                                    </div>
                                </div>
                                <h5 class="card-title text-secondary mt-1"><i class="fas fa-rupee-sign text-muted"></i> ${
                                  car.rent_per_day
                                } <span style="color: black; font-size: 14px;">/day</span></h5>
                                ${bookingForm}
                            </div>
                        </div>
                    </div>`;
          });
          offset += data.length; // Update offset for next fetch
        } else {
          moreBtn.style.display = "none"; // Hide more button if no more data
        }
      })
      .catch((error) => {
        console.error("Error fetching data:", error);
        loading.style.display = "none";
      });
  }

  // Initial fetch
  fetchCars();

  // Event listener for more button
  moreBtn.addEventListener("click", fetchCars);
});
