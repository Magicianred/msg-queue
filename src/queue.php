<?php
	namespace peter\components;
	
	class Queue {
    
		/**
		* Stores our queue semaphore.
		* @var resource
		*/
		private static $queue = null;
		
		public function __construct($queueKey, $queueStart, $queueEnd) {
			$this -> queueKey = $queueKey;
			$this -> queueStart = $queueStart;
			$this -> queueEnd = $queueEnd;
		}
  
		/**
		* getQueue: Returns the semaphore message resource.
		*
		* @access public
		*/
		public static function getQueue() {
    
			// Some unique ID
			//define('QUEUE_KEY', 12345);
        
			// Different type of actions
			//define('QUEUE_TYPE_START', 1);
			//define('QUEUE_TYPE_END', 2);
        
			// Setup the queue
			self::$queue = msg_get_queue($this -> queueKey);
        
			// Return the queue
			return self::$queue;
      
		}
		
		/**
		* addMessage: Given a key, store a new message into our queue.
		*
		* @param $key string - Reference to the message (PK)
		* @param $data array - Some data to pass into the message
		*/
		public static function addMessage($key, $data = array()) {
			// What to send
			$message = new Message($key, $data);
			
			// Try to send the message
			if(msg_send(self::$queue, $this -> queueStart, $message)) {
				print_r(msg_stat_queue(self::$queue));
			}
			else {
				echo "Error adding to the queue";
			}
		}
	}
?>