# KonkretnyGCM
This simple class helps retrieving tokens with devices using the GCM (Google Cloud Messaging), and sending push messages to the device by the GCM.

files:
-gettoken.php - this file is responsible for receiving tokens GCM, which are sent by the device, for example by Android smartphone.

-sendpush.php - this file is responsible for sending push messages to the device.

-KonkretnyGCM.class.php - Class file.

IMPORTANT
Files gettoken.php and sendpush.php require editing. Open the file and analyze its settings. It is not difficult :)

Examples
- gettoken.php?token = exampletokencode - write the code sent to the database
- sendpush.php - will send a message about the content of the set inside the file.

Have fun :)
http://konkretny.pl/

v. 1.0.0