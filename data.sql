-- Insert data into the facilities table. 
-- This includes only the default data that was present in Assessment 1.
INSERT INTO facilities (facilityname, description, caption, price, configuration, capacity, image)
VALUES
    ('STANDARD ROOM', 'Comfortable room with all basic amenities.', 'Experience a restful night.', 120, '1 DOUBLE', 2, 'room1.jpeg'),
    ('SUPERIOR ROOM', 'Elegant room with a view of the city.', 'Elegance meets comfort.', 150, '1 QUEEN', 2, 'room2.jpeg'),
    ('SUPREME ROOM', 'Premium room with spacious interiors.', 'Premium stay for the discerning traveler.', 150, '1 KING', 2, 'room3.jpeg'),
    ('SUPREME ROOM (DUAL OCCUPANCY)', 'Perfect for friends traveling together.', 'Dual comfort for double fun.', 150, '2 SINGLE', 2, 'room4.jpeg'),
    ('HOTEL RESTAURANT', 'Savor delicious meals in our in-house restaurant.', 'A treat for your taste buds.', 50, 'N/A', 60, 'restaurant.jpeg'),
    ('CONFERENCE ROOM', 'Ideal for business meetings and conferences.', 'Business in style.', 200, 'N/A', 100, 'conference.jpeg');