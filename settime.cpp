//COMPILE AS settime.bin

#include <chrono>
#include <iostream>
#include <boost/interprocess/shared_memory_object.hpp>
#include <boost/interprocess/mapped_region.hpp>

using namespace boost::interprocess;

// Settings
const char shm_name[] = "srv_taboo_db0";

int main(int argc, char* argv[]) {

    // Create Memory
    std::size_t shm_size = sizeof(std::chrono::time_point<std::chrono::system_clock>);
    shared_memory_object appdata_shm (open_or_create,shm_name,read_write);
    appdata_shm.truncate(shm_size);

    // Map Memory
    mapped_region memdata_shm (appdata_shm,read_write,0,shm_size);
    auto address_shm = (std::chrono::time_point<std::chrono::system_clock>*)memdata_shm.get_address();

    // Start Timer
    address_shm[0] = std::chrono::system_clock::now();

}
