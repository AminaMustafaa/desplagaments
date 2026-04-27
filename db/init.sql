CREATE TABLE IF NOT EXISTS tasques (
  id INT AUTO_INCREMENT PRIMARY KEY,
  text VARCHAR(255) NOT NULL,
  done BOOLEAN DEFAULT FALSE
);

INSERT INTO tasques (text, done) VALUES
  ('Crear el repositori a GitHub', true),
  ('Configurar GitHub Pages', false),
  ('Configurar Docker Compose', false);
