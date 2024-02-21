--User
CREATE TABLE easycook_user (
    id SERIAL PRIMARY KEY,
    lastname_user VARCHAR(50) NOT NULL,
    firstname_user VARCHAR(50) NOT NULL,
    email_user VARCHAR(320) NOT NULL UNIQUE,
    is_verified_user BOOLEAN NOT NULL DEFAULT FALSE,
    password_user VARCHAR(255) NOT NULL,
    token_user VARCHAR(64) NOT NULL,
    type_user TEXT NOT NULL CHECK (type_user IN ('viewer', 'chef', 'admin')),
    is_deleted BOOLEAN NOT NULL DEFAULT FALSE,
    inserted_at TIMESTAMPTZ DEFAULT current_timestamp,
    updated_at TIMESTAMPTZ
);

CREATE OR REPLACE FUNCTION update_updated_at_column()
RETURNS TRIGGER AS $$
BEGIN
    NEW.updated_at = current_timestamp;
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER update_updated_at_easycook_user
BEFORE UPDATE ON easycook_user
FOR EACH ROW
EXECUTE FUNCTION update_updated_at_column();
--Settings
CREATE TABLE easycook_setting (
    name_setting VARCHAR(50) NOT NULL,
    slogan_setting VARCHAR(255) NOT NULL,
    logo_url_setting TEXT NOT NULL,
    color_setting VARCHAR(50) NOT NULL
);
--Recipe
CREATE TABLE easycook_recipe (
    id SERIAL PRIMARY KEY,
    id_user_recipe INT NOT NULL,
    title_recipe VARCHAR(50) NOT NULL,
    ingredient_recipe TEXT NOT NULL,
    instruction_recipe TEXT NOT NULL,
    image_url_recipe TEXT NOT NULL,
    is_deleted BOOLEAN DEFAULT FALSE,
    inserted_at TIMESTAMPTZ DEFAULT current_timestamp,
    updated_at TIMESTAMPTZ DEFAULT NULL,
	CONSTRAINT fk_user_recipe FOREIGN KEY (id_user_recipe) REFERENCES easycook_user(id)
);
CREATE TRIGGER update_updatedat_easycook_recipe
BEFORE UPDATE ON easycook_recipe
FOR EACH ROW
EXECUTE FUNCTION update_updated_at_column();
--Category
CREATE TABLE easycook_category (
    id SERIAL PRIMARY KEY,
    name_category VARCHAR(50) NOT NULL,
    is_deleted BOOLEAN NOT NULL DEFAULT FALSE,
    updated_at TIMESTAMPTZ DEFAULT NULL
);
CREATE TRIGGER update_updated_at_easycook_category
BEFORE UPDATE ON easycook_category
FOR EACH ROW
EXECUTE FUNCTION update_updated_at_column();

--Recipe category
CREATE TABLE easycook_recipe_category (
    id SERIAL PRIMARY KEY,
    id_recipe_category INT NOT NULL,
    id_category INT NOT NULL,
    CONSTRAINT fk_recipe_category_recipe FOREIGN KEY (id_recipe_category) REFERENCES easycook_recipe(id),
    CONSTRAINT fk_recipe_category_category FOREIGN KEY (id_category) REFERENCES easycook_category(id)
);
--Page
CREATE TABLE easycook_page (
    id SERIAL PRIMARY KEY,
    title_page TEXT NOT NULL,
    content_page jsonb NOT NULL
);
--Review
CREATE TABLE easycook_review (
    id SERIAL PRIMARY KEY,
    id_user_review INT NOT NULL,
    id_recipe_review INT NOT NULL,
    title_review VARCHAR(50) NOT NULL,
    content_review TEXT NOT NULL,
    status_review TEXT NOT NULL CHECK (status_review IN ('accept', 'process', 'cancel', '')),
    is_deleted BOOLEAN NOT NULL DEFAULT FALSE,
    inserted_at TIMESTAMPTZ DEFAULT current_timestamp,
    updated_at TIMESTAMPTZ DEFAULT NULL,
    CONSTRAINT fk_user_review FOREIGN KEY (id_user_review) REFERENCES easycook_user(id),
    CONSTRAINT fk_recipe_review FOREIGN KEY (id_recipe_review) REFERENCES easycook_recipe(id)
);
CREATE TRIGGER update_updated_at_easycook_review
BEFORE UPDATE ON easycook_review
FOR EACH ROW
EXECUTE FUNCTION update_updated_at_column();
--Menu
CREATE TABLE easycook_menu (
    id SERIAL PRIMARY KEY,
    title_menu VARCHAR(50) NOT NULL,
    description_menu TEXT NOT NULL
);
--Pivot recipe et mmenu
CREATE TABLE easycook_recipe_menu (
    id SERIAL PRIMARY KEY,
    id_recipe INT NOT NULL,
    id_menu INT NOT NULL,
    CONSTRAINT fk_recipe_menu_recipe FOREIGN KEY (id_recipe) REFERENCES easycook_recipe(id),
    CONSTRAINT fk_recipe_menu_menu FOREIGN KEY (id_menu) REFERENCES easycook_menu(id)
);
--Navigation
CREATE TABLE easycook_navigation (
    id SERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    link VARCHAR(255)UNIQUE,
    position INT,
    parent_id INT,
    level INT,
    id_page INT DEFAULT 0

);










