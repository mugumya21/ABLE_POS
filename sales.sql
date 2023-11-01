-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 10, 2015 at 05:39 AM
-- Server version: 5.5.16
-- PHP Version: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `sales`
--

-- --------------------------------------------------------



-- --------------------------------------------------------

--
-- Table structure for table customer`
--

CREATE TABLE IF NOT EXISTS `customer` (
  `customer_id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_name` varchar(100) NOT NULL,
  `address` varchar(100) NOT NULL,
  `contact` varchar(100) NOT NULL,
  `membership_number` varchar(100) NOT NULL,
  `prod_name` varchar(550) NOT NULL,
  `expected_date` varchar(500) NOT NULL,
  `note` varchar(500) NOT NULL,
  PRIMARY KEY (`customer_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

-- --------------------------------------------------------

--

-- --------------------------------------------------------

--


--
-- Table structure for table `purchases`
--

CREATE TABLE IF NOT EXISTS `purchases` (
  `transaction_id` int(11) NOT NULL AUTO_INCREMENT,
  `invoice_number` varchar(100) NOT NULL,
  `date` varchar(100) NOT NULL,
  `suplier` varchar(100) NOT NULL,
  `remarks` varchar(100) NOT NULL,
  PRIMARY KEY (`transaction_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

-- --------------------------------------------------------

--
-- Table structure for table `purchases_item`

-- Table structure for table `sales`
--

CREATE TABLE IF NOT EXISTS `sales` (
  `transaction_id` int(11) NOT NULL AUTO_INCREMENT,
  `invoice_number` varchar(100) NOT NULL,
  `cashier` varchar(100) NOT NULL,
  `date` varchar(100) NOT NULL,
  `type` varchar(100) NOT NULL,
  `amount` varchar(100) NOT NULL,
  `profit` varchar(100) NOT NULL,
  `due_date` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `balance` varchar(100) NOT NULL,
  PRIMARY KEY (`transaction_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=142 ;

-- --------------------------------------------------------

--


--
-- Table structure for table `supliers`
--

CREATE TABLE IF NOT EXISTS `supliers` (
  `suplier_id` int(11) NOT NULL AUTO_INCREMENT,
  `suplier_name` varchar(100) NOT NULL,
  `suplier_address` varchar(100) NOT NULL,
  `suplier_contact` varchar(100) NOT NULL,
  `contact_person` varchar(100) NOT NULL,
  `note` varchar(500) NOT NULL,
  PRIMARY KEY (`suplier_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------


--
-- Table structure for table `expenses`
--

CREATE TABLE IF NOT EXISTS `expenses` (
  `expenses_id` int(11) NOT NULL AUTO_INCREMENT,
  `expense_type` varchar(500) NOT NULL,
  `amount_spent` varchar(100) NOT NULL,
  `comment` varchar(100) NOT NULL,
  `date` varchar(500) NOT NULL,
  `date_timestamp` TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
  PRIMARY KEY (`expenses_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=5;

-- --------------------------------------------------------


--
-- Table structure for table `expensescategory`
--

CREATE TABLE IF NOT EXISTS `expensescategory` (
  `expense_type_id` int(11) NOT NULL AUTO_INCREMENT,
  `expense_type` varchar(100) NOT NULL,
  PRIMARY KEY (`expense_type_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------



--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `position` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;




-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `name`, `position`) VALUES
(1, 'admin', 'admin21', 'Derrick', 'Admin'),
(2, 'cashier', 'cashier21', 'Nicholas', 'Cashier'),
(3, 'admin', 'admin22', 'William', 'SuperAdmin');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;







CREATE TABLE  IF NOT EXISTS purchasesreport (
    purchasesreport_id INT AUTO_INCREMENT PRIMARY KEY,
    purchases_type VARCHAR(255) NOT NULL,
    date DATE NOT NULL,
    amount DECIMAL(10, 2) NOT NULL,
    suplier_name VARCHAR(255) NOT NULL
);

CREATE TABLE  IF NOT EXISTS purchasescategory (
    purchasescategory_id INT AUTO_INCREMENT PRIMARY KEY,
    purchases_type VARCHAR(255) NOT NULL
);




CREATE TABLE IF NOT EXISTS receipts (
    receipt_id INT AUTO_INCREMENT PRIMARY KEY,
    customer_name VARCHAR(255),
    total_amount DECIMAL(10, 2),
    receipt_date DATE NOT NULL DEFAULT CURRENT_DATE
);



-- from here, the tables are not inserted into the server automatically.  so i have to enter them manually. 


CREATE TABLE   IF NOT EXISTS orders (
    order_id INT AUTO_INCREMENT PRIMARY KEY,
    customer_name VARCHAR(255),
    total_amount DECIMAL(10, 2),
    order_date DATE NOT NULL DEFAULT CURRENT_DATE
);






-- Create the invoices table
CREATE TABLE  IF NOT EXISTS  invoices (
    invoice_id INT AUTO_INCREMENT PRIMARY KEY,
    customer_name VARCHAR(255),
    total_amount DECIMAL(10, 2),
 invoice_date DATE NOT NULL DEFAULT CURRENT_DATE);


CREATE TABLE IF NOT EXISTS cashpayouts (
    payout_id INT AUTO_INCREMENT PRIMARY KEY,
    from_cashaccount VARCHAR(255) NOT NULL,
    date DATE NOT NULL,
    amount DECIMAL(10, 2) NOT NULL,
    expense_type VARCHAR(255) NOT NULL,
    comment VARCHAR(255)
);


-- Create bankaccounts table
CREATE TABLE IF NOT EXISTS bankaccounts (
    bankaccount_id INT AUTO_INCREMENT PRIMARY KEY,
    account_name VARCHAR(255) NOT NULL,
    amount DECIMAL(10, 2) NOT NULL,
    INDEX (account_name)
);

CREATE TABLE IF NOT EXISTS cashtransfers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    date DATE NOT NULL,
    amount DECIMAL(10, 2) NOT NULL,
    to_account VARCHAR(255) NOT NULL,
    comment TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);



-- MADE NEW CHANGES ---


CREATE TABLE   IF NOT EXISTS salessummary (
    salessummary_id INT PRIMARY KEY AUTO_INCREMENT,
    sales_type VARCHAR(10000) NOT NULL,
    date DATE NOT NULL,
    amount DECIMAL(10, 2) NOT NULL,
    comment TEXT
 
);



CREATE TABLE   IF NOT EXISTS salescategory (
    salescategory_id INT AUTO_INCREMENT PRIMARY KEY,
    sales_type VARCHAR(10000) NOT NULL
);


 -- add the table and the create an id and amount where the amount is to be stored.
-- Create the cashathand table
CREATE TABLE IF NOT EXISTS  cashathand (
    id INT AUTO_INCREMENT PRIMARY KEY,
    amount DECIMAL(10, 2) DEFAULT 0
);

-- Insert initial record into cashathand table
INSERT INTO cashathand (id, amount) VALUES (1, 0.00);



ALTER TABLE expenses 
ADD COLUMN from_account VARCHAR(255)  NOT NULL;



CREATE TABLE  IF NOT EXISTS installation_info_table (
    id INT PRIMARY KEY AUTO_INCREMENT,
    installation_timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


INSERT INTO installation_info_table (installation_timestamp) VALUES (CURRENT_TIMESTAMP);
-- $sql = "SELECT installation_timestamp FROM installation_info_table WHERE id = 1"; in main/index.php


<<<<<<< HEAD
=======
CREATE TABLE IF NOT EXISTS productcategory (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_type VARCHAR(255) NOT NULL
);

>>>>>>> 6db173236628f469e90a02b59b00f3bf99d51461

-- Table structure for table `products`
--
CREATE TABLE IF NOT EXISTS `products` (
  `product_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_name` varchar(200) NOT NULL,
  `product_type` VARCHAR(200) NOT NULL,
  `qty_unit` VARCHAR(200) NOT NULL,
  `expiry_date` DATE NOT NULL,
  `date_arrival` DATE NOT NULL,
  `o_price` decimal(10, 2) NOT NULL, 
  `price` decimal(10, 2) NOT NULL,  
  `supplier` varchar(100) NOT NULL,
  `qty` int(10) NOT NULL DEFAULT 0,
  `qty_sold` int(10) NOT NULL DEFAULT 0,
  `qty_left` int(10) NOT NULL DEFAULT 0,
  PRIMARY KEY (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=58;





-- add these below... manually
-- Create the 'receipt_items' table
CREATE TABLE   IF NOT EXISTS receipt_items (
    receipt_item_id INT AUTO_INCREMENT PRIMARY KEY,
    receipt_id INT,
    product_id INT,
    quantity INT,
    price DECIMAL(10, 2),
    total DECIMAL(10, 2),
    product_name VARCHAR(255),
    FOREIGN KEY (receipt_id) REFERENCES receipts(receipt_id),
    FOREIGN KEY (product_id) REFERENCES products(product_id)
);

<<<<<<< HEAD

CREATE TABLE IF NOT EXISTS customersledger (
    customersledger_id INT AUTO_INCREMENT PRIMARY KEY,
    customer_name VARCHAR(255) NOT NULL,
    date DATE NOT NULL,
    dr_amount DECIMAL(10, 2) NOT NULL,
    cr_amount DECIMAL(10, 2) NOT NULL,
    details TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);



CREATE TABLE IF NOT EXISTS productcategory (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_type VARCHAR(255) NOT NULL
);
=======
>>>>>>> 6db173236628f469e90a02b59b00f3bf99d51461
