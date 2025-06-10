SELECT mt.`id`, mt.`name_menu` AS menu_name, mt.`img`, mt.`description`, mt.price, c.`name` AS cate_name
                                    FROM menu_items mt
                                    JOIN categories c ON mt.category_id = 1;
                                 