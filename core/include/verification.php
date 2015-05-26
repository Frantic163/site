<?php
    class Verification{
        public function getRole($isSession){
           if(is_array($isSession)) {
                if(isset($isSession['uname'])) {
                        if($isSession['access'] < 1) {
                            return false;
                        } else {
                            return true;
                        }
                } else {
                    return false;
                }
            } else {
                return false;
            }
        }
    }

