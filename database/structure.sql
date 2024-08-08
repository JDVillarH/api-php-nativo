-- Main tables
CREATE TABLE pokemon (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name TEXT NOT NULL,
    image TEXT NULL
);

CREATE TABLE stats (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name TEXT NOT NULL
);

CREATE TABLE types (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name TEXT NOT NULL
);

CREATE TABLE moves (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name TEXT NOT NULL
);

CREATE TABLE abilities (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name TEXT NOT NULL
);


-- Relational tables
CREATE TABLE stats_pokemon (
    id INT AUTO_INCREMENT PRIMARY KEY,
    stat_id INT NOT NULL,
    pokemon_id INT NOT NULL,
    base_stat INT NOT NULL,
    FOREIGN KEY (stat_id) REFERENCES stats(id),
    FOREIGN KEY (pokemon_id) REFERENCES pokemon(id)
);

CREATE TABLE types_pokemon (
    id INT AUTO_INCREMENT PRIMARY KEY,
    type_id INT NOT NULL,
    pokemon_id INT NOT NULL,
    FOREIGN KEY (type_id) REFERENCES types(id),
    FOREIGN KEY (pokemon_id) REFERENCES pokemon(id)
);

CREATE TABLE moves_pokemon (
    id INT AUTO_INCREMENT PRIMARY KEY,
    move_id INT NOT NULL,
    pokemon_id INT NOT NULL,
    FOREIGN KEY (move_id) REFERENCES moves(id),
    FOREIGN KEY (pokemon_id) REFERENCES pokemon(id)
);

CREATE TABLE abilities_pokemon (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ability_id INT NOT NULL,
    pokemon_id INT NOT NULL,
    FOREIGN KEY (ability_id) REFERENCES abilities(id),
    FOREIGN KEY (pokemon_id) REFERENCES pokemon(id)
);


-- Views
CREATE VIEW pokemon_stat_view AS
SELECT stats.id, stats.name, stats_pokemon.base_stat, stats_pokemon.pokemon_id
FROM stats 
INNER JOIN stats_pokemon ON stats.id = stats_pokemon.stat_id;

CREATE VIEW pokemon_type_view AS
SELECT types.name, types.id, types_pokemon.pokemon_id
FROM types
INNER JOIN types_pokemon ON types.id = types_pokemon.type_id;

CREATE VIEW pokemon_move_view AS
SELECT moves.name, moves_pokemon.pokemon_id
FROM moves
INNER JOIN moves_pokemon ON moves.id = moves_pokemon.move_id;

CREATE VIEW pokemon_ability_view AS
SELECT abilities.name, abilities_pokemon.pokemon_id
FROM abilities
INNER JOIN abilities_pokemon ON abilities.id = abilities_pokemon.ability_id;