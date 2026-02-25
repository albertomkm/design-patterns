# Design Patterns Learning Repository

A comprehensive repository dedicated to learning and practicing **Design Patterns** with practical PHP implementations. This repository documents my journey through various design patterns, from creation to behavioral patterns.

## 📚 Overview

This project serves as an educational resource containing practical examples of design patterns. Each pattern is implemented with clear, well-documented code examples that demonstrate real-world usage and best practices.

## 📁 Project Structure

```
design-pattern/
├── README.md                          # This file
└── creational-patterns/
    ├── factory-method/               # Factory Method Pattern
    │   ├── AppNotification.php        # Email & SMS notifications
    │   └── AppReports.php             # CSV & PDF report generation
    └── [more patterns coming...]
```

## 🎯 Creational Patterns

### Factory Method
**Location:** `creational-patterns/factory-method/`

The Factory Method pattern allows you to create objects without specifying the exact classes that will be instantiated. It delegates object creation to subclasses, promoting loose coupling and extensibility.

#### Examples Included:
- **AppNotification.php** - Creating different notification types (Email, SMS)
- **AppReports.php** - Generating different report formats (CSV, PDF)

**Key Concepts:**
- Abstract creator classes with factory methods
- Concrete implementations for different product types
- Template methods for shared logic
- Type hints and proper interface definitions

## 🚀 Getting Started

### Prerequisites
- PHP 7.4 or higher

### Running Examples

Each file contains executable example code at the bottom. You can run them directly:

```bash
php creational-patterns/factory-method/AppNotification.php
php creational-patterns/factory-method/AppReports.php
```

## 📖 Pattern Learning Path

This repository follows a structured learning path:

1. **Creational Patterns** (Object creation mechanisms)
   - ✅ Factory Method
   - ⏳ Singleton
   - ⏳ Builder
   - ⏳ Prototype
   - ⏳ Abstract Factory

2. **Structural Patterns** (Object composition)
   - ⏳ Adapter
   - ⏳ Bridge
   - ⏳ Composite
   - ⏳ Decorator
   - ⏳ Facade
   - ⏳ Proxy

3. **Behavioral Patterns** (Object interaction and responsibility)
   - ⏳ Chain of Responsibility
   - ⏳ Command
   - ⏳ Iterator
   - ⏳ Mediator
   - ⏳ Memento
   - ⏳ Observer
   - ⏳ State
   - ⏳ Strategy
   - ⏳ Template Method
   - ⏳ Visitor

## 💡 Code Conventions

To maintain consistency across all patterns:

- **Type Hints:** Always use return types and parameter types
- **Naming:** Concrete classes explicitly identify their type (e.g., `EmailNotification`, `PDFReport`)
- **Interfaces:** Define contracts for products
- **Examples:** Each file includes usage examples at the bottom
- **Comments:** Clear explanations of pattern intent and structure

## 📝 How to Add New Patterns

When adding a new pattern:

1. Create a new directory under the appropriate category
2. Implement the pattern with concrete examples
3. Include executable example code
4. Document the pattern intent and structure
5. Update this README with the new pattern

## 🎓 Learning Resources

Each pattern implementation includes:
- Clear abstract base class definitions
- Multiple concrete implementations
- Practical use cases
- Type-safe interfaces
- Template methods for shared behavior

## 📌 Notes

This is an active learning repository. Patterns and examples may be expanded or refined as my understanding deepens.

---

**Status:** 🚀 In Progress - Building foundational patterns

**Last Updated:** February 2026
