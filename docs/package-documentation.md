# Documentación interna

## Sobre el prefijo "kal"

"kal" es una abreviatura de Kernel Abstraction Layer, un concepto clave tanto en la arquitectura hexagonal como en DDD. La idea es la siguiente:

Kernel: Se refiere al núcleo de la aplicación, donde reside la lógica de negocio pura. En DDD, se prioriza la centralidad del dominio, el "corazón" del sistema, libre de detalles de infraestructura.

Abstraction Layer: Representa la capa que separa el núcleo del dominio de las dependencias externas, permitiendo que la lógica central permanezca limpia y desacoplada de tecnologías o frameworks específicos.

Al usar el prefijo "kal", indicas que los elementos asociados (ya sean clases, componentes CSS u otros) forman parte de ese esfuerzo de mantener una separación clara entre el dominio y otros aspectos de la aplicación. Esto refuerza la intención de seguir buenas prácticas de diseño, tal como lo promueve la arquitectura hexagonal y DDD, al mantener el núcleo de la aplicación protegido y aislado de cambios externos.

Además, esta nomenclatura ayuda a comunicar de manera inmediata que esos componentes están pensados para interactuar con el dominio de forma segura y controlada, siguiendo principios de diseño modular y escalable, algo que también se alinea con la filosofía de Laravel y el desarrollo moderno.
