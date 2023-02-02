import hashlib, time

#---Parameters---
proof_length = 2 #change to determine required number of proof digits
proof_char = '0' #character magic number is searching to match
max_tries = 100000000 #maximum number of attempts before terminating loop

hash_algorithm = "sha3_256" #specifies hash algorithm ("sha256", "md5", etc.)

#Create proof string (ex. "0000")
proof_string = '' #stores a string of n number of proof_char
for i in range(0, proof_length):
    proof_string += proof_char

data_string = 'hinput' #can be anything, input "transactions" for bitcoin

start_time = time.time() #mark start time

for magic_number in range(0, max_tries):
    magic_string = hashlib.new(hash_algorithm, (data_string+str(magic_number)).encode()).hexdigest()
    print(f"Time: {int((time.time()-start_time)//60)}:{(time.time()-start_time)%60}") #display time each loop (commenting out this line may improve speed)
    if(proof_string == magic_string[:(proof_length)]): #check if the first digits are equal to the n number of hash character
        print(f"Magic number: {magic_number} gives hash {magic_string}") #display magic number and hash
        print(f"Total time: {int((time.time()-start_time)//60)}:{(time.time()-start_time)%60}") #dislpay total elapsed time
        break
    elif(magic_number == max_tries-1): #checks if maximum number of attempts has been reached to display unique message
        print(f"Maximum attempts reached. ({max_tries})") #alert that maximum attemps reached, display maximum attemptss
        print(f"Total time: {int((time.time()-start_time)//60)}:{(time.time()-start_time)%60}") #dislpay total elapsed time
