//COMPILE AS tsRead.bin

#include "shmtimer.h"

#include <chrono>
#include <iostream>
#include <thread>
#include <boost/interprocess/shared_memory_object.hpp>
#include <boost/interprocess/mapped_region.hpp>

using namespace boost::interprocess;

int main(int argc, char* argv[]) {
    
    // Open Memory
    bool isopen=true;
    std::size_t shm_size = SHM_NTMR*sizeof(std::chrono::time_point<std::chrono::system_clock>);
    shared_memory_object appdata_shm;
    try {
        appdata_shm = shared_memory_object(open_only,SHM_NAME,read_write);
    }
    catch(const interprocess_exception e) {
        appdata_shm = shared_memory_object(create_only,SHM_NAME,read_write);
        appdata_shm.truncate(shm_size);
        isopen=false;
    }

    // Map Memory
    mapped_region memdata_shm (appdata_shm,read_write,0,shm_size);
    auto address_shm = (std::chrono::time_point<std::chrono::system_clock>*)memdata_shm.get_address();
    
    // Check or Start Timer
    auto current_ts = std::chrono::system_clock::now();
    if(!isopen) {
        address_shm[0]=current_ts;
        address_shm[1]=current_ts;
    }
    auto positional_time = std::chrono::duration_cast<std::chrono::milliseconds>(address_shm[1].time_since_epoch());

    std::cout << positional_time.count();

}
