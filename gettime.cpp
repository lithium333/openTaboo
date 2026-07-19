//COMPILE AS gettime.cgi

#include <chrono>
#include <iostream>
#include <thread>
#include <boost/interprocess/shared_memory_object.hpp>
#include <boost/interprocess/mapped_region.hpp>

using namespace boost::interprocess;

// Settings
const char shm_name[] = "srv_taboo_db0";

int main(int argc, char* argv[]) {
    
    // Create Memory
    bool isopen=true;
    std::size_t shm_size = sizeof(std::chrono::time_point<std::chrono::system_clock>);
    shared_memory_object appdata_shm;
    try {
        appdata_shm = shared_memory_object(open_only,shm_name,read_write);
    }
    catch(const interprocess_exception e) {
        appdata_shm = shared_memory_object(create_only,shm_name,read_write);
        appdata_shm.truncate(shm_size);
        isopen=false;
    }

    // Map Memory
    mapped_region memdata_shm (appdata_shm,read_write,0,shm_size);
    auto address_shm = (std::chrono::time_point<std::chrono::system_clock>*)memdata_shm.get_address();
    
    // Check or Start Timer
    auto current_ts = std::chrono::system_clock::now();
    if(!isopen)
        address_shm[0]=current_ts;
    auto differential_time = std::chrono::duration_cast<std::chrono::milliseconds>(current_ts - address_shm[0]);

    // Output req!
    std::cout << "Content-type: text/event-stream\r\nCache-Control: no-cache\r\nConnection: keep-alive" << std::endl << std::endl;
    std::cout << differential_time.count() << std::endl << std::endl;
    // LOOP
    while(true) {
        current_ts = std::chrono::system_clock::now();
        differential_time = std::chrono::duration_cast<std::chrono::milliseconds>(current_ts - address_shm[0]);
        std::cout << "data:" << differential_time.count() << std::endl << std::endl;
        std::this_thread::sleep_for(std::chrono::milliseconds(100));
    }
    

}
