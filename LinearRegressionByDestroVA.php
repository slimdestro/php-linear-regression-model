<?php
/**
 * LinearRegressionByDestroVA
 */
class LinearRegressionByDestroVA
{
        private $coefficients; 
        private $intercept; 
        private $x; 
        private $y; 
        private $learning_rate; 
        private $epochs; 
        private $cost; 
        private $m; 
        private $n; 
 
   // Constructor(Initializes parameters)
   function __construct($x, $y, $learning_rate = 0.01, $epochs = 1000) { 
        $this->y = $y;
        $this->learning_rate = $learning_rate;
        $this->epochs = $epochs;
        $this->m = count($x);
        $this->n = count($x[0]);
        $this->coefficients = array_fill(0, $this->n, 0);
        $this->intercept = 0;
	} 
    
    public function fit() {
        for ($i = 0; $i < $this->epochs; $i++) {
            $predictions = $this->predict($this->x);
            $this->cost = $this->cost($predictions);
            $this->update_coefficients($predictions);
        }
    }
    
    public function predict($x) {
        $predictions = array();
        for ($i = 0; $i < $this->m; $i++) {
            $prediction = $this->intercept;
            for ($j = 0; $j < $this->n; $j++) {
                $prediction += $this->coefficients[$j] * $x[$i][$j];
            }
            $predictions[] = $prediction;
        }
        return $predictions;
    }
    
    public function cost($predictions) {
        $cost = 0;
        for ($i = 0; $i < $this->m; $i++) {
            $cost += pow($predictions[$i] - $this->y[$i], 2);
        }
        return $cost / (2 * $this->m);
    }
    
    public function update_coefficients($predictions) {
        $d_intercept = 0;
        $d_coefficients = array_fill(0, $this->n, 0);
        for ($i = 0; $i < $this->m; $i++) {
            $d_intercept += ($predictions[$i] - $this->y[$i]);
            for ($j = 0; $j < $this->n; $j++) {
                $d_coefficients[$j] += ($predictions[$i] - $this->y[$i]) * $this->x[$i][$j];
            }
        }
        $this->intercept -= ($this->learning_rate * $d_intercept) / $this->m;
        for ($j = 0; $j < $this->n; $j++) {
            $this->coefficients[$j] -= ($this->learning_rate * $d_coefficients[$j]) / $this->m;
        }
    }
    
    public function get_coefficients() {
        return $this->coefficients;
    }
    
    public function get_intercept() {
        return $this->intercept;
    }
    
    public function get_cost() {
        return $this->cost;
    }
}
?>