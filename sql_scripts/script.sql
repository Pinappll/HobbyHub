--User
CREATE TABLE easycook_user (
    id SERIAL PRIMARY KEY,
    lastname_user VARCHAR(50) NOT NULL,
    firstname_user VARCHAR(50) NOT NULL,
    email_user VARCHAR(320) NOT NULL UNIQUE,
    isverified_user BOOLEAN NOT NULL DEFAULT FALSE,
    password_user VARCHAR(255) NOT NULL,
    token_user VARCHAR(64) NOT NULL,
    type_user TEXT NOT NULL CHECK (type_user IN ('customer', 'chef', 'admin')),
    isdeleted BOOLEAN NOT NULL DEFAULT FALSE,
    insertedat TIMESTAMPTZ DEFAULT current_timestamp,
    updatedat TIMESTAMPTZ
);

CREATE OR REPLACE FUNCTION update_updatedat_column()
RETURNS TRIGGER AS $$
BEGIN
    NEW.updatedat = current_timestamp;
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER update_updatedat_easycook_user
BEFORE UPDATE ON easycook_user
FOR EACH ROW
EXECUTE FUNCTION update_updatedat_column();
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
    id_user_recipie INT NOT NULL,
    title_recipie VARCHAR(50) NOT NULL,
    ingredient_recipie TEXT NOT NULL,
    instruction_recipie TEXT NOT NULL,
    image_url_recipe TEXT NOT NULL,
    isdeleted BOOLEAN DEFAULT FALSE,
    insertedat TIMESTAMPTZ DEFAULT current_timestamp,
    updatedat TIMESTAMPTZ DEFAULT NULL,
	CONSTRAINT fk_user_recipie FOREIGN KEY (id_user_recipie) REFERENCES easycook_user(id)
);
CREATE TRIGGER update_updatedat_easycook_recipe
BEFORE UPDATE ON easycook_recipe
FOR EACH ROW
EXECUTE FUNCTION update_updatedat_column();
--Page
CREATE TABLE easycook_page (
    id SERIAL PRIMARY KEY,
    title_page TEXT NOT NULL,
    content_page TEXT NOT NULL,
    markup_meta_pages TEXT NOT NULL,
    id_user INT NOT NULL,
    CONSTRAINT fk_user_page FOREIGN KEY (id_user) REFERENCES easycook_user(id)
);
--Review
CREATE TABLE easycook_review (
    id SERIAL PRIMARY KEY,
    id_user_review INT NOT NULL,
    id_recipe_review INT NOT NULL,
    title_review VARCHAR(50) NOT NULL,
    content_review TEXT NOT NULL,
    status_review TEXT NOT NULL CHECK (status_review IN ('accept', 'process', 'cancel', '')),
    isdeleted BOOLEAN NOT NULL DEFAULT FALSE,
    insertedat TIMESTAMPTZ DEFAULT current_timestamp,
    updatedat TIMESTAMPTZ DEFAULT NULL,
    CONSTRAINT fk_user_review FOREIGN KEY (id_user_review) REFERENCES easycook_user(id),
    CONSTRAINT fk_recipe_review FOREIGN KEY (id_recipe_review) REFERENCES easycook_recipe(id)
);
CREATE TRIGGER update_updatedat_easycook_reviw
BEFORE UPDATE ON easycook_review
FOR EACH ROW
EXECUTE FUNCTION update_updatedat_column();
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












