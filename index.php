<?php
<?php
1. CREATE PROCEDURE daily_cleanup()
BEGIN
  DELETE FROM carts WHERE created_at < NOW() - INTERVAL 2 DAY;
  DELETE FROM cart_items WHERE cart_id NOT IN (SELECT id FROM carts);
END 

 CREATE EVENT IF NOT EXISTS cleanup_event
ON SCHEDULE EVERY 1 DAY
STARTS TIMESTAMP(CURDATE() + INTERVAL 2 HOUR)
DO
  CALL daily_cleanup();

2. mysqldump -u <username> -p<password> --no-create-info --no-create-db --skip-triggers --skip-add-drop-table --ignore-table=gift_shop.activity_log gift_shop > gift_shop_backup_$(date +"%Y%m%d").sql
  30 2 * * * /path/to/mysqldump_command.sh

3.
innodb_buffer_pool_size = 50G
innodb_log_file_size = 2G
innodb_flush_log_at_trx_commit = 1
innodb_flush_method = O_DIRECT
innodb_io_capacity = 2000
innodb_io_capacity_max = 4000

4. CREATE VIEW order_data AS
SELECT
  o.id AS order_id,
  oi.product_id,
  oi.quantity,
  o.shipment_address,
  c.customer_contact_info
FROM orders o
JOIN order_items oi ON o.id = oi.order_id
JOIN customers c ON o.customer_id = c.id;

CREATE USER 'delivery_service'@'%' IDENTIFIED BY 'password';
GRANT SELECT ON gift_shop.order_data TO 'delivery_service'@'%';