<?php 
class LinearRegressionByDestroVA {
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

// Example
$x = [[1, 2], [2, 4], [3, 6], [4, 8]];
$y = [3, 5, 7, 9];

$model = new LinearRegressionByDestroVA($x, $y);
$model->fit();

$coefficients = $model->get_coefficients();
$intercept = $model->get_intercept();
$cost = $model->get_cost();

echo "Coefficients: " . implode(', ', $coefficients) . "\n";
echo "Intercept: " . $intercept . "\n";
echo "Cost: " . $cost . "\n";
      