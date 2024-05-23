<?php

/**
 * Trie le tableau de données en fonction d'une colonne spécifiée et d'un ordre de tri.
 *
 * @param array $data Le tableau de données à trier.
 * @param string $sortColumn La colonne sur laquelle effectuer le tri.
 * @param string $sortOrder L'ordre de tri (ascendant ou descendant).
 *
 * @return array  Le tableau trié.
 */
function trierTableau($data, $sortColumn, $sortOrder)
{
	usort($data, function ($a, $b) use ($sortColumn, $sortOrder) {
		return sortData($a, $b, $sortColumn, $sortOrder);
	});

	return $data;
}

/**
 * Filtre le tableau de données en fonction d'un terme de recherche spécifié.
 *
 * @param array $data Le tableau de données à filtrer.
 * @param string $searchTerm Le terme de recherche.
 *
 * @return array  Le tableau filtré.
 */
function filtrerTableau($data, $searchTerm)
{
	if (empty($searchTerm)) {
		return $data;
	}

	$filteredData = array();
	foreach ($data as $row) {
		foreach ($row as $cell) {
			if (stripos($cell, $searchTerm) !== false) {
				$filteredData[] = $row;
				break;
			}
		}
	}

	return $filteredData;
}

/**
 * Pagine le tableau de données en fonction du nombre d'éléments par page et du numéro de page.
 *
 * @param array $data Le tableau de données à paginer.
 * @param int $itemsPerPage Le nombre d'éléments par page.
 * @param int $page Le numéro de la page.
 *
 * @return array  Un tableau contenant les données paginées et le nombre total de pages.
 */
function paginerTableau($data, $itemsPerPage, $page)
{
	$totalItems = count($data);
	$totalPages = ceil($totalItems / $itemsPerPage);

	$startIndex = ($page - 1) * $itemsPerPage;
	$endIndex = $startIndex + $itemsPerPage - 1;
	$endIndex = min($endIndex, $totalItems - 1);

	$pagedData = array_slice($data, $startIndex, $itemsPerPage);

	return array(
		'pagedData' => $pagedData,
		'totalPages' => $totalPages,
	);
}

/**
 * Fonction utilitaire pour le tri du tableau de données.
 *
 * @param array $a La première ligne à comparer.
 * @param array $b La deuxième ligne à comparer.
 * @param string $column La colonne sur laquelle effectuer le tri.
 * @param string $order L'ordre de tri (ascendant ou descendant).
 *
 * @return int  Un entier négatif si $a est inférieur à $b, un entier positif si $a est supérieur à $b, ou 0 si les deux sont égaux.
 */
function sortData($a, $b, $column, $order)
{
	$valueA = $a[$column];
	$valueB = $b[$column];

	if ($valueA == $valueB) {
		return 0;
	}

	if ($order == 'asc') {
		return ($valueA < $valueB) ? -1 : 1;
	} else {
		return ($valueA > $valueB) ? -1 : 1;
	}
}

/**
 * Recherche le tableau de données en fonction d'un terme de recherche spécifié.
 * Cette fonction est identique à la fonction "filtrerTableau".
 *
 * @param array $data Le tableau de données à rechercher.
 * @param string $searchTerm Le terme de recherche.
 *
 * @return array  Le tableau filtré.
 */
function rechercherTableau($data, $searchTerm)
{
	if (empty($searchTerm)) {
		return $data;
	}

	$filteredData = array();
	foreach ($data as $row) {
		foreach ($row as $cell) {
			if (stripos($cell, $searchTerm) !== false) {
				$filteredData[] = $row;
				break;
			}
		}
	}

	return $filteredData;
}
