use	moviesdb;

SELECT JSON_ARRAYAGG(
  JSON_OBJECT(
    'movieId', m.movieId,
    'title', m.title,
    'year', m.year,
    'genre', m.genre,
    'summary', m.summary,
    'artist', JSON_OBJECT(
      'artistId', a.artistId,
      'surname', a.surname,
      'name', a.name,
      'DOB', a.DOB
    ),
    'country', JSON_OBJECT(
      'code', c.code,
      'name', c.name,
      'language', c.language
    )
  )
) INTO OUTFILE 'C:\Users\lunar\Desktop\dumps\movie.json' 
FROM movie m
JOIN artist a ON m.artistId = a.artistId
JOIN country c ON m.countryCode = c.code;




SELECT JSON_ARRAYAGG(
  JSON_OBJECT(
    'code', code,
    'name', name,
    'language', language
  )
) INTO OUTFILE 'C:\Users\lunar\Desktop\dumps\country.json'
FROM country;



SELECT JSON_ARRAYAGG(
  JSON_OBJECT(
    'artistId', artistId,
    'surname', surname,
    'name', name,
    'DOB', DOB
  )
) INTO OUTFILE 'C:\Users\lunar\Desktop\dumps\artist.json'
FROM artist;



SELECT JSON_ARRAYAGG(
  JSON_OBJECT(
    'movieId', r.movieId,
    'artist', JSON_OBJECT(
      'artistId', a.artistId,
      'surname', a.surname,
      'name', a.name,
      'DOB', a.DOB
    ),
    'roleName', r.roleName
  )
) INTO OUTFILE 'C:\Users\lunar\Desktop\dumps\role.json'
FROM role r
JOIN artist a ON r.artistId = a.artistId;




SELECT JSON_ARRAYAGG(
  JSON_OBJECT(
    'email', email,
    'surname', surname,
    'name', name,
    'region', region
  )
) INTO OUTFILE 'C:\Users\lunar\Desktop\dumps\internet_user.json'
FROM internet_user;





SELECT JSON_ARRAYAGG(
  JSON_OBJECT(
    'email', s.email,
    'user', JSON_OBJECT(
      'surname', u.surname,
      'name', u.name,
      'region', u.region
    ),
    'movie', JSON_OBJECT(
      'movieId', m.movieId,
      'title', m.title,
      'year', m.year,
      'genre', m.genre,
      'summary', m.summary
    ),
    'score', s.score
  )
) INTO OUTFILE 'C:\Users\lunar\Desktop\dumps\score_movie.json'
FROM score_movie s
JOIN internet_user u ON s.email = u.email
JOIN movie m ON s.movieId = m.movieId;

